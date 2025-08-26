<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        $produk = $query->latest()->get();
        $kategori = Kategori::all();

        $produk = Produk::query();

if (request('kategori')) {
    $produk->where('kategori_id', request('kategori'));
}

if (request('search')) {
    $produk->where('nama', 'like', '%' . request('search') . '%');
}

$produk = $produk->with('kategori')->get();


        return view('user.dashboard', compact('produk', 'kategori'));
    }
}
