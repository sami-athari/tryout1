<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Notification;

class ChatController extends Controller
{
    /**
     * Tampilkan daftar chat
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Jika login sebagai admin
        if ($user->role === 'admin') {
            $users = User::where('role', 'user')->get();
            $selectedUser = null;
            $messages = collect();

            if ($request->has('user_id')) {
                $selectedUser = User::findOrFail($request->user_id);

                // Ambil semua pesan antara admin dan user
                $messages = Message::where(function ($q) use ($selectedUser) {
                    $q->where('sender_id', Auth::id())
                      ->where('receiver_id', $selectedUser->id);
                })->orWhere(function ($q) use ($selectedUser) {
                    $q->where('sender_id', $selectedUser->id)
                      ->where('receiver_id', Auth::id());
                })->orderBy('created_at')->get();

                // 🔧 Perbaikan: gunakan receiver_id, bukan user_id
                Notification::where('receiver_id', Auth::id())
                    ->where('sender_id', $selectedUser->id)
                    ->update(['is_read' => true]);
            }

            return view('admin.chat', compact('users', 'selectedUser', 'messages'));
        }

        // Jika login sebagai user
        else {
            $admin = User::where('role', 'admin')->first();

            $messages = Message::where(function ($q) use ($user, $admin) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $admin->id);
            })->orWhere(function ($q) use ($user, $admin) {
                $q->where('sender_id', $admin->id)
                  ->where('receiver_id', $user->id);
            })->orderBy('created_at')->get();

            // Tandai notifikasi dari admin sebagai sudah dibaca
            Notification::where('receiver_id', $user->id)
                ->where('sender_id', $admin->id)
                ->update(['is_read' => true]);

            return view('user.chat', compact('messages', 'admin'));
        }
    }

    /**
     * Simpan pesan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan pesan
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Buat notifikasi baru
        Notification::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'type' => 'chat',
            'message' => $request->message,
        ]);

        return redirect()->back();
    }

    /**
     * Tampilkan halaman chat dengan user tertentu
     */
    public function show($id)
    {
        $receiver = User::findOrFail($id);

        // Ambil semua pesan antara user login dan receiver
        $messages = Message::where(function ($query) use ($id) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        // Tandai notifikasi dari user ini sudah dibaca
        Notification::where('receiver_id', auth()->id())
            ->where('sender_id', $id)
            ->update(['is_read' => true]);

        return view('chat.show', compact('receiver', 'messages'));
    }

    /**
     * Chatbot sederhana untuk pertanyaan otomatis
     */
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
