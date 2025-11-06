<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Transaction;

class AboutController extends Controller
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


        return view('user.about', compact('about', 'totalProduk', 'produk', 'userCount', 'transactionCount','kategori','totalSold'));
    }
}
