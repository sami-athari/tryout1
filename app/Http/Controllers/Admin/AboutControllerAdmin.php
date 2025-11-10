<?php

namespace App\Http\Controllers\Admin;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;
use App\Models\Kategori;

class AboutControllerAdmin extends \App\Http\Controllers\Controller
{
    public function index()
    {
         $totalSold = Produk::sum('transaction_count');
        $about = About::first(); // ambil data pertama dari tabel abouts
        $kategori = Kategori::all();
        // contoh statistik (hiasan)
        $totalProduk = Produk::count();
        $userCount = User::count();
        $transactionCount = Transaction::count();
        // Ambil data produk terbaru beserta relasi kategori
        $produk = Produk::paginate(4);


        return view('admin.about.index', compact('about', 'totalProduk', 'produk', 'userCount', 'transactionCount','kategori','totalSold'));
    }

    public function edit()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = About::first();
        $data = $request->only(['title','description','mission','why','tagline']);

        if ($request->hasFile('image')) {
            if ($about && $about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        if ($about) {
            $about->update($data);
        } else {
            $about = About::create($data);
        }

        return redirect()->route('admin.about.index')->with('success','Konten About berhasil diperbarui!');
    }
}
