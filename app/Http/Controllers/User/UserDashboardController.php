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
        $query = Produk::query();

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        // Ambil data produk terbaru beserta relasi kategori
        $produk = $query->with('kategori')->latest()->get();

        // Ambil semua kategori untuk filter di view (mencegah undefined variable di layout)
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
