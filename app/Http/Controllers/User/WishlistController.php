<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tampilkan wishlist user
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('produk')
            ->get();

        return view('user.wishlist', compact('wishlist'));
    }

    // Tambah produk ke wishlist
    public function store($produk_id)
    {
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Produk sudah ada di wishlist kamu!');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk_id,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke wishlist!');
    }

    // Hapus dari wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wishlist->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
