<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProductController extends Controller
{
    /**
     * Show product detail page.
     * Provides: $produk, $related (collection), $avgRating (float), $reviews (collection)
     */
    public function show($id)
    {
        // Load product with kategori and reviews (if relations exist)
        $produk = Produk::with(['kategori', 'reviews.user'])->findOrFail($id);

        // average rating (safe)
        $avgRating = (float) round($produk->reviews()->avg('rating') ?? 0, 1);

        // latest reviews (with user)
        $reviews = $produk->reviews()->with('user')->latest()->get();

        // related products: same category, exclude current product
        $related = collect();
        if ($produk->kategori_id ?? null) {
            $related = Produk::where('kategori_id', $produk->kategori_id)
                ->where('id', '<>', $produk->id)
                ->take(6)
                ->get();
        }

        return view('user.deskripsi', compact('produk', 'related', 'avgRating', 'reviews'));
    }
}
