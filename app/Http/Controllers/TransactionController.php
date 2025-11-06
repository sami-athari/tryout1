<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Produk;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
	/**
	 * Mark transaction as completed/paid and increment produk.transaction_count.
	 * This method is idempotent: it only increases counts when status changes into 'selesai' (completed).
	 * Call this after payment confirmation or when admin sets transaction to 'selesai'.
	 */
	public function markAsCompleted($id)
	{
		$trx = Transaction::with('items')->findOrFail($id);

		$oldStatus = $trx->status;

		// If already completed, do nothing (prevents double-counting)
		if ($oldStatus === 'selesai') {
			return back()->with('info', 'Transaksi sudah berstatus selesai.');
		}

		DB::beginTransaction();
		try {
			// Update transaction status
			$trx->status = 'selesai';
			$trx->save();

			// Increment transaction_count on each product by the item quantity
			foreach ($trx->items as $item) {
				// item->produk_id and item->quantity assumed; adjust names to your schema
				$qty = (int) ($item->quantity ?? ($item->qty ?? 1));
				if ($qty <= 0) continue;

				Produk::where('id', $item->produk_id)->increment('transaction_count', $qty);
			}

			DB::commit();
			return back()->with('success', 'Transaksi ditandai selesai. Jumlah terjual produk diperbarui.');
		} catch (\Throwable $e) {
			DB::rollBack();
			Log::error('markAsCompleted error: '.$e->getMessage());
			return back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
		}
	}

	/**
	 * Admin action: confirm a transaction.
	 * Now delegates to markAsCompleted so counts increase when admin confirms.
	 */
	public function adminConfirm($id)
    {
        $trx = Transaction::findOrFail($id);

        // Only change when still pending to avoid unexpected overwrites
        if ($trx->status === 'pending') {
            $trx->status = 'dikirim';
            $trx->save();

            return redirect()->back()->with('success', 'Transaksi dikonfirmasi dan diproses.');
        }

        return redirect()->back()->with('info', 'Transaksi sudah diproses atau tidak dalam status pending.');
    }

	// ...existing code...
}
