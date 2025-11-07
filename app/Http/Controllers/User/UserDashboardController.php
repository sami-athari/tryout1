<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaction;

class UserDashboardController extends Controller
{
    /**
     * ✅ Dashboard Product List (Search + Filter + Sorting)
     */
    public function index(Request $request)
    {
        $query = Produk::query()->with(['kategori', 'reviews']);

        /* ------------------------------
         ✅ SEARCH
        ------------------------------ */
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        /* ------------------------------
         ✅ FILTER KATEGORI
        ------------------------------ */
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        /* ------------------------------
         ✅ PRICE MIN & MAX
        ------------------------------ */
        if ($request->filled('price_min')) {
            $query->where('harga', '>=', (int) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('harga', '<=', (int) $request->price_max);
        }

        /* ------------------------------
         ✅ SORTING EXCLUSIVE
         - best seller TIDAK boleh digabung dengan sort_harga
        ------------------------------ */

        $sortHarga = $request->sort_harga;        // asc / desc
        $sortBest  = $request->sort;              // best

        // ✅ Kalau BEST SELLER aktif → NONAKTIFKAN sorting harga
        if ($sortBest === 'best') {
            $sortHarga = null;
        }

        // ✅ Kalau sorting harga aktif → NONAKTIFKAN BEST SELLER
        if ($sortHarga === 'asc' || $sortHarga === 'desc') {
            $sortBest = null;
        }

        /* ------------------------------
         ✅ APPLY SORTING
        ------------------------------ */

        // ✅ Best Seller (Transaction Count)
        if ($sortBest === 'best') {
            $query->orderBy('transaction_count', 'desc');
        }

        // ✅ Lowest / Highest Price
        if ($sortHarga === 'asc') {
            $query->orderBy('harga', 'asc');
        }
        if ($sortHarga === 'desc') {
            $query->orderBy('harga', 'desc');
        }

        // ✅ Default Sorting (if no sorting at all)
        if (!$sortHarga && !$sortBest) {
            $query->latest('id');
        }

        /* ------------------------------
         ✅ PAGINATION (KEEP QUERY PARAM)
        ------------------------------ */
        $produk = $query->paginate(12)->appends($request->query());

        $kategori = Kategori::all();

        return view('user.dashboard', compact('produk', 'kategori'));
    }

    /**
     * ✅ SHOW PRODUCT DETAIL
     */
    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        $related = Produk::where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->take(4)
            ->get();

        $kategori = Kategori::all();

        return view('user.deskripsi', compact('produk', 'related', 'kategori'));
    }
}
