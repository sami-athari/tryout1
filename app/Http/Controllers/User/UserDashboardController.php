<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class UserDashboardController extends Controller
{
    /**
     * Halaman dashboard / daftar produk (dengan search + filter kategori)
     */
    public function index(Request $request)
{
    $query = Produk::query()->with('kategori');

    // 🔍 Filter pencarian nama produk
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // 🔽 Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // 💰 Filter harga minimum & maksimum
    if ($request->filled('min_harga')) {
        $query->where('harga', '>=', $request->min_harga);
    }
    if ($request->filled('max_harga')) {
        $query->where('harga', '<=', $request->max_harga);
    }

    // ↕️ Sortir harga (termurah / termahal)
    if ($request->filled('sort')) {
        if ($request->sort == 'low_high') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'high_low') {
            $query->orderBy('harga', 'desc');
        }
    } else {
        $query->latest('id'); // default: produk terbaru
    }

    // 🔹 Ambil hasil dengan pagination
    $produk = $query->paginate(8)->appends($request->query());

    // 🔹 Ambil semua kategori untuk filter dropdown
    $kategori = Kategori::all();

    return view('user.dashboard', compact('produk', 'kategori'));
}


    /**
     * Halaman detail produk
     * Route: GET /produk/{id} => user.produk.show
     */
    public function show($id)
    {
        // Ambil produk beserta relasi kategori
        $produk = Produk::with('kategori')->findOrFail($id);

        // Ambil produk terkait (dalam kategori sama), exclude produk saat ini
        $related = Produk::where('kategori_id', $produk->kategori_id)
                         ->where('id', '!=', $produk->id)
                         ->take(4)
                         ->get();

        // Ambil kategori untuk layout / dropdown (jika layout membutuhkan)
        $kategori = Kategori::all();

        return view('user.deskripsi', compact('produk', 'related', 'kategori'));
    }
}
