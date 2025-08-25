<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $items = Cart::with('produk')
                     ->where('user_id', Auth::id())
                     ->get();

        return view('user.cart', compact('items'));
    }

    // Tambah produk ke keranjang
    public function add($produk_id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('produk_id', $produk_id)
                        ->first();

        if ($cartItem) {
            $cartItem->jumlah += 1; // <-- disesuaikan dengan nama kolom
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk_id,
                'jumlah' => 1 // <-- disesuaikan
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Hapus produk dari keranjang
    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Update jumlah produk
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($id);
        $produkStok = $cartItem->produk->stok;

        $newJumlah = min($request->quantity, $produkStok);
        $cartItem->jumlah = $newJumlah; // <-- ganti quantity jadi jumlah
        $cartItem->save();

        return response()->json([
            'success' => true,
            'jumlah' => $cartItem->jumlah
        ]);
    }
}
