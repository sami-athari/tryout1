<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Kategori;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $items = Cart::with('produk')
                     ->where('user_id', Auth::id())
                     ->get();

        $kategori = Kategori::all();
        return view('user.cart', compact('items','kategori'));
    }

    // Tambah produk ke keranjang
   public function add($produk_id, Request $request)
{
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('produk_id', $produk_id)
                    ->first();

    // Ambil stok produk
    $produk = \App\Models\Produk::findOrFail($produk_id);

    // Kalau produk sudah ada di cart
    if ($cartItem) {
        // Jangan melebihi stok
        if ($cartItem->jumlah < $produk->stok) {
            $cartItem->jumlah += 1; // default tambah 1
            $cartItem->save();
        } else {
            return redirect()->back()->with('error', 'Jumlah melebihi stok!');
        }
    } else {
        // Tambah baru dengan default 1
        Cart::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk_id,
            'jumlah' => 1
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
