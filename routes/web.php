<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\PDFController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\RoleMiddleware;

// ⬇️ Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ⬇️ Custom Auth Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ⬇️ Redirect after login based on role
Route::get('/redirect', function () {
    $role = Auth::user()->role ?? null;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'user') {
        return redirect()->route('user.dashboard');
    }

    return redirect('/login'); // fallback
});

// ⬇️ Admin Routes - Only accessible for role 'admin'
Route::prefix('admin')->middleware(['auth', RoleMiddleware::class . ':admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/transactions', function () {
        $transactions = \App\Models\Transaction::with(['user', 'items.produk'])->orderBy('created_at', 'desc')->get();
        return view('admin.transactions.index', compact('transactions'));
    })->name('transactions.index');

    Route::post('/transactions/konfirmasi/{id}', function ($id) {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update(['status' => 'dikirim']);
        return redirect()->back()->with('success', 'Transaksi dikonfirmasi!');
    })->name('transactions.konfirmasi');
});

// ⬇️ User Routes - Only accessible for role 'user'
Route::prefix('user')->middleware(['auth', RoleMiddleware::class . ':user'])->name('user.')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/{id}', [CartController::class, 'updateQuantity'])->name('cart.update'); // ✅ update quantity

    // Checkout
    Route::get('/checkout', [TransactionController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions/selesai/{id}', [TransactionController::class, 'terimaPesanan'])->name('transactions.selesai');

    // PDF Struk
    Route::get('/struk/{id}', [PDFController::class, 'cetakStruk'])->name('struk');
});

// ⬇️ About Page (umum)
Route::get('/about', function () {
    return view('user.about');
})->name('user.about');

// ⬇️ Chat Routes (auth common)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::post('/chatbot', [ChatController::class, 'chatbot'])->name('chat.chatbot');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
});
