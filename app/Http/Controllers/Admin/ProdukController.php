<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan semua produk
     */
    public function index(Request $request)
{
    $query = Produk::query();

    // Jika ada pencarian
    if ($request->has('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Ambil semua produk sesuai hasil filter
    $produk = $query->get();

    return view('admin.produk.index', compact('produk'));
}


    /**
     * Form about
     */
    public function about()
    {
        return view('admin.about');
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|numeric|min:10000',
            'stok'      => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:6000',
        ], [
            'harga.min' => '⚠️ Harga minimal adalah Rp 10.000',
            'stok.min'  => '⚠️ Stok minimal adalah 1',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');

        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|numeric|min:10000',
            'stok'      => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ], [
            'harga.min' => '⚠️ Harga minimal adalah Rp 10.000',
            'stok.min'  => '⚠️ Stok minimal adalah 1',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // ❌ Cegah hapus kalau stok masih ada
        if ($produk->stok > 0) {
            return redirect()->route('admin.produk.index')
                             ->with('error', 'Produk tidak bisa dihapus karena stok masih tersisa.');
        }

        // ❌ Cegah hapus kalau masih ada transaksi aktif
        if (method_exists($produk, 'transactionItems')) {
            $adaPesananAktif = $produk->transactionItems()
                ->whereHas('transaction', function ($q) {
                    $q->whereIn('status', ['pending', 'dikirim']);
                })->exists();

            if ($adaPesananAktif) {
                return redirect()->route('admin.produk.index')
                                 ->with('error', 'Produk tidak bisa dihapus karena masih ada dalam pesanan yang belum selesai.');
            }
        }

        // ✅ Hapus foto
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
