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
