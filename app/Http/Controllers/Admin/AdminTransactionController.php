<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index()
    {

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $transactions = Transaction::with(['user', 'items.produk'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }
    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $request->validate([
            'status' => 'required|string|in:pending,dikirim,selesai,dibatalkan',
            'shipping_note' => 'nullable|string|max:1000'
        ]);

        $transaction = Transaction::findOrFail($id);

        $transaction->status = $request->status;
        $transaction->shipping_note = $request->shipping_note;
        $transaction->save();

        return back()->with('success', 'Status dan catatan pengiriman berhasil diperbarui.');
    }

    public function konfirmasi($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $transaction = Transaction::with('items.produk')->findOrFail($id);

        // Pastikan hanya transaksi yang belum diproses yang bisa dikonfirmasi
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        // Tidak perlu create TransactionItem lagi karena sudah dibuat saat checkout
        // Tidak perlu kurangi stok lagi, stok juga sudah dikurangi saat checkout

        // Update status transaksi jadi dikirim
        $transaction->update(['status' => 'dikirim']);

        return back()->with('success', 'Transaksi telah dikonfirmasi. Status diperbarui menjadi dikirim.');
    }
}
