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
        $about = About::first(); // ambil data pertama dari tabel abouts
        $kategori = Kategori::all();
        // contoh statistik (hiasan)
        $totalProduk = Produk::count();
        $userCount = User::count();
        $transactionCount = Transaction::count();

        return view('user.about', compact('about', 'totalProduk', 'userCount', 'transactionCount','kategori'));
    }
}
