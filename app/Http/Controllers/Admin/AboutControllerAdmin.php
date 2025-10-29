<?php

namespace App\Http\Controllers\Admin;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

class AboutControllerAdmin extends \App\Http\Controllers\Controller
{
    public function index()
    {
         $produk = Produk::paginate(2);
        $totalProduk = Produk::count();
        $userCount = User::where('role', 'user')->count();
        $transactionCount = Transaction::count();

        $about = About::first();
        return view('admin.about.index', compact('about','produk', 'totalProduk', 'userCount', 'transactionCount'));
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
