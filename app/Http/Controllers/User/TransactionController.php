<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display checkout form.
     */
    public function checkoutForm()
    {
        $items = Cart::with('produk')->where('user_id', Auth::id())->get();
        return view('user.checkout', compact('items'));
    }

    /**
     * Process checkout and create a new transaction.
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'telepon' => 'required|digits_between:10,13|numeric',
            'metode_pembayaran' => 'required|string',
        ]);

        $user = Auth::user();
        $items = $user->cart()->with('produk')->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong!');
        }

        $total = $items->sum(fn($item) => $item->produk ? $item->produk->harga * $item->jumlah : 0);

        DB::beginTransaction();
        try {
            // Create transaction header
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create transaction items + update stock
            foreach ($items as $item) {
                if (!$item->produk) continue;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'produk_id'      => $item->produk_id,
                    'jumlah'         => $item->jumlah,
                    'harga'          => $item->produk->harga,
                ]);

                // Decrease stock
                $produk = $item->produk;
                $produk->stok = max(0, $produk->stok - $item->jumlah);
                $produk->save();
            }

            // Clear user cart
            $user->cart()->delete();

            DB::commit();
            return redirect()->route('user.transactions')
                ->with('success', 'Checkout berhasil! Pesanan sedang diproses.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat proses checkout.');
        }
    }

    /**
     * Show all transactions for the logged-in user.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('items.produk')
            ->get();

        return view('user.transactions', ['transaksi' => $transactions]);
    }

    /**
     * Mark a transaction as completed ("selesai") by the user.
     * When completed, update sold count for each product.
     */
    public function terimaPesanan($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        // Prevent double-counting if already marked as selesai
        if ($transaction->status === 'selesai') {
            return back()->with('info', 'Pesanan ini sudah berstatus selesai.');
        }

        DB::beginTransaction();
        try {
            // Update transaction status
            $transaction->status = 'selesai';
            $transaction->save();

            // Update sold count per product
            foreach ($transaction->items as $item) {
                $qty = (int) ($item->jumlah ?? 1);
                if ($qty > 0) {
                    Produk::where('id', $item->produk_id)->increment('transaction_count', $qty);
                }
            }

            DB::commit();
            return back()->with('success', 'Pesanan selesai. Jumlah produk terjual telah diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('TerimaPesanan error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pesanan.');
        }
    }

    /**
     * Admin confirms a transaction (sets status to "dikirim").
     */
    public function adminConfirm($id)
    {
        $trx = Transaction::findOrFail($id);

        if ($trx->status === 'pending') {
            $trx->status = 'dikirim';
            $trx->save();
            return redirect()->back()->with('success', 'Transaksi dikonfirmasi dan diproses.');
        }

        return redirect()->back()->with('info', 'Transaksi sudah diproses atau tidak dalam status pending.');
    }

    /**
     * Internal function for marking transaction as completed (for admin or system use).
     * This can be called from other controllers if needed.
     */
    public function markAsCompleted($id)
    {
        $trx = Transaction::with('items')->findOrFail($id);

        if ($trx->status === 'selesai') {
            return back()->with('info', 'Transaksi sudah berstatus selesai.');
        }

        DB::beginTransaction();
        try {
            $trx->status = 'selesai';
            $trx->save();

            foreach ($trx->items as $item) {
                $qty = (int) ($item->jumlah ?? 1);
                if ($qty > 0) {
                    Produk::where('id', $item->produk_id)->increment('transaction_count', $qty);
                }
            }

            DB::commit();
            return back()->with('success', 'Transaksi ditandai selesai dan jumlah terjual diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('markAsCompleted error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
        }
    }

    /**
     * Return global best seller products ordered by the Produk.transaction_count column.
     *
     * Usage: $this->bestSellersGlobal(10);
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection of Produk models
     */
    public function bestSellersGlobal(int $limit = 10)
    {
        // Return products ordered by transaction_count (descending)
        return Produk::orderByDesc('transaction_count')
            ->take($limit)
            ->get();
    }

    /**
     * Return products that the specified user bought the most.
     * Aggregates TransactionItem.jumlah for transactions belonging to the user,
     * then returns Produk models with an appended purchased_qty attribute.
     *
     * Usage: $this->bestSellersForUser(Auth::id(), 10);
     *
     * @param int|null $userId
     * @param int $limit
     * @return \Illuminate\Support\Collection of Produk models with ->purchased_qty
     */
    public function bestSellersForUser(?int $userId = null, int $limit = 10)
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) {
            return collect();
        }

        // Aggregate quantities per product for this user's transactions.
        $rows = TransactionItem::select('transaction_items.produk_id', DB::raw('SUM(transaction_items.jumlah) as total_qty'))
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.user_id', $userId)
            // consider only meaningful statuses (adjust if needed)
            ->whereIn('transactions.status', ['dikirim', 'selesai'])
            ->groupBy('transaction_items.produk_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get();

        if ($rows->isEmpty()) {
            return collect();
        }

        $produkIds = $rows->pluck('produk_id')->toArray();
        $produks = Produk::whereIn('id', $produkIds)->get()->keyBy('id');

        // Map aggregated rows to Produk models and attach purchased_qty
        $result = $rows->map(function ($r) use ($produks) {
            $p = $produks->get($r->produk_id);
            if (!$p) {
                return null;
            }
            // Attach purchased_qty attribute for easy access in views
            $p->purchased_qty = (int) $r->total_qty;
            return $p;
        })->filter()->values();

        // Ensure ordering by purchased_qty desc (rows were ordered but keep safe)
        return $result->sortByDesc(fn($p) => $p->purchased_qty)->values();
    }
}
