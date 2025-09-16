<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\User;
use App\Models\Transaction;

class AboutControllerAdmin extends Controller
{
    public function index()
    {
        $produk = Produk::latest()->take(3)->get();
        $totalProduk = Produk::count();
        $userCount = User::where('role', 'admin')->count();
        $transactionCount = Transaction::count();

        return view('admin.about', compact('produk', 'totalProduk', 'userCount', 'transactionCount'));
    }
}
