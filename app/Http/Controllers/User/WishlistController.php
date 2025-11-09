<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tampilkan wishlist
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('produk')
            ->get();

        return view('user.wishlist', compact('wishlist'));
    }

    // Tambah ke wishlist
    public function store($produk_id)
    {
        // jika sudah ada → return
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->first();

        if ($exists) {
            return response()->json(['status' => 'exists']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk_id,
        ]);

        return response()->json(['status' => 'added']);
    }

    // Hapus wishlist
    public function destroy($produk_id)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->delete();

        return response()->json(['status' => 'removed']);
    }
}
