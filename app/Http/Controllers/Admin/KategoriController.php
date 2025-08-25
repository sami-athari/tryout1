<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            (new \App\Http\Middleware\RoleMiddleware)->handle($request, function () {}, 'admin');
            return $next($request);
        });
    }

    // Index kategori dengan menghitung jumlah buku
    public function index()
    {
        $kategoris = Kategori::withCount('bukus')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kategori', 'public');
        }

        Kategori::create($data);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->bukus_count > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Hapus semua buku di kategori ini dulu sebelum menghapus kategori.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
