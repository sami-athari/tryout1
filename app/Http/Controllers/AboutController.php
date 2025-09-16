<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use App\Models\Transaction;

class AboutController extends Controller
{
    public function index()
    {
        $produk = Produk::latest()->take(3)->get();
        $totalProduk = Produk::count();
        $userCount = User::where('role', 'user')->count();
        $transactionCount = Transaction::count();

        return view('user.about', compact('produk', 'totalProduk', 'userCount', 'transactionCount'));
    }
}
