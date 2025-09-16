<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Produk;

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

        // Kurangi stok produk sesuai item transaksi
        foreach ($transaction->items as $item) {
            $produk = $item->produk;
            if ($produk) {
                $produk->stok = max(0, $produk->stok - $item->jumlah); // biar stok gak minus
                $produk->save();
            }
        }

        // Update status transaksi
        $transaction->update(['status' => 'dikirim']);

        return back()->with('success', 'Transaksi telah dikonfirmasi dan stok berhasil dikurangi.');
    }
}
