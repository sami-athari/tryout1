<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Review;
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
         ✅ FILTER RATING (BARU)
        ------------------------------ */
        if ($request->filled('rating')) {
            $rating = (int) $request->rating;

            $query->whereHas('reviews', function ($q) use ($rating) {
                $q->selectRaw('produk_id, AVG(rating) as avg_rating')
                  ->groupBy('produk_id')
                  ->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }

        /* ------------------------------
         ✅ SORTING VARIABLES
        ------------------------------ */
        $sortHarga = $request->sort_harga;   // asc / desc
        $sortType  = $request->sort;         // latest / best

        /* ------------------------------
         ✅ EXCLUSIVE SORTING RULES
        ------------------------------ */

        // Jika BEST SELLER aktif → Harga & Latest dimatikan
        if ($sortType === 'best') {
            $sortHarga = null;
        }

        // Jika sorting harga aktif → Nonaktifkan BEST & LATEST
        if ($sortHarga === 'asc' || $sortHarga === 'desc') {
            $sortType = null;
        }

        /* ------------------------------
         ✅ APPLY SORTING
        ------------------------------ */

        // ✅ Best Seller
        if ($sortType === 'best') {
            $query->orderBy('transaction_count', 'desc');
        }

        // ✅ Produk Terbaru (BARU DITAMBAH)
        if ($sortType === 'latest') {
            $query->latest('id');
        }

        // ✅ Termurah / Termahal
        if ($sortHarga === 'asc') {
            $query->orderBy('harga', 'asc');
        }
        if ($sortHarga === 'desc') {
            $query->orderBy('harga', 'desc');
        }

        // ✅ Default Sorting (Jika tidak memilih apa pun)
        if (!$sortHarga && !$sortType) {
            $query->latest('id');
        }

        /* ------------------------------
         ✅ PAGINATION (KEEP QUERY PARAMS)
        ------------------------------ */
        $produk = $query->paginate(8)->appends($request->query());

        $kategori = Kategori::all();
        $reviews  = Review::all();

        return view('user.dashboard', compact('produk', 'kategori', 'reviews'));
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
