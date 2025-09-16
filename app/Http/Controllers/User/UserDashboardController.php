<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Ambil data produk terbaru
        $produk = $query->latest()->get();

        return view('user.dashboard', compact('produk'));
    }
}
