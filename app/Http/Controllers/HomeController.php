<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

use App\Models\Kategori;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $produk = Produk::with('kategori')->latest('id')->paginate(8);
        return view('welcome', compact('produk'));
    }
}
