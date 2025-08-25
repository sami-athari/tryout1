<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $users = User::where('role', 'user')->get();
            $selectedUser = null;
            $messages = collect();

            if ($request->has('user_id')) {
                $selectedUser = User::findOrFail($request->user_id);

                // Hapus notif ketika admin buka chat dari user
                session()->forget('has_new_message_from_user_' . $selectedUser->id);

                $messages = Message::where(function ($query) use ($selectedUser) {
                    $query->where('sender_id', Auth::id())
                          ->where('receiver_id', $selectedUser->id);
                })->orWhere(function ($query) use ($selectedUser) {
                    $query->where('sender_id', $selectedUser->id)
                          ->where('receiver_id', Auth::id());
                })
                ->with('sender', 'receiver')
                ->orderBy('created_at')
                ->get();
            }

            return view('admin.chat', compact('users', 'selectedUser', 'messages'));
        } else {
            $admin = User::where('role', 'admin')->first();

            $messages = Message::where(function ($query) use ($user, $admin) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $admin->id);
            })->orWhere(function ($query) use ($user, $admin) {
                $query->where('sender_id', $admin->id)
                      ->where('receiver_id', $user->id);
            })
            ->with('sender', 'receiver')
            ->orderBy('created_at')
            ->get();

            // Hapus notif saat user buka chat
            session()->forget('has_new_message_for_user_' . $user->id);

            return view('user.chat', compact('messages'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        // Set notif untuk penerima
        $receiver = User::find($request->receiver_id);
        if ($receiver && $receiver->role === 'admin') {
            session()->put('has_new_message_from_user_' . Auth::id(), true);
        }

        if ($receiver && $receiver->role === 'user') {
            session()->put('has_new_message_for_user_' . $receiver->id, true);
        }

        return redirect()->back();
    }

    public function chatbot(Request $request)
{
    $request->validate([
        'question' => 'required|string'
    ]);

    $question = strtolower($request->question);
    $answer = '';

    if (str_contains($question, 'status') || str_contains($question, 'pesanan')) {
        $answer = 'Untuk mengecek status pesananmu, silakan masuk ke halaman navbar > Riwayat Pesanan.';
    } elseif (str_contains($question, 'bayar') || str_contains($question, 'pembayaran')) {
        $answer = 'Pembayaran bisa dilakukan via Dana, OVO, Gopay. Silakan masukkan nomor dan metode pembayaran di halaman Checkout.';
    } elseif (str_contains($question, 'admin') || str_contains($question, 'kontak')) {
        $answer = 'Admin kami akan menghubungi kamu dalam 1x24 jam. Atau hubungi langsung melalui email: admin@example.com';
    } else {
        $answer = 'Maaf, saya belum mengerti pertanyaanmu. Silakan hubungi admin langsung.';
    }

    return response()->json([
        'answer' => $answer
    ]);
}

}
