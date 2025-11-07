<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AboutControllerAdmin;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Produk;
use App\Http\Controllers\User\DeskriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\LanguageController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $produk = Produk::latest()->take(8)->get();
    return view('welcome', compact('produk'));
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Custom Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Redirect After Login
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {
    $role = Auth::user()->role ?? null;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'user'  => redirect()->route('user.dashboard'),
        default => redirect('/login'),
    };
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', RoleMiddleware::class . ':admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::post('/admin/transactions/update/{id}', [AdminTransactionController::class, 'updateStatus'])
    ->name('admin.transactions.update');

    // CRUD Kategori & Produk
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Transaksi
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/konfirmasi/{id}', [AdminTransactionController::class, 'konfirmasi'])->name('transactions.konfirmasi');

    // About - single record
    Route::get('/about', [AboutControllerAdmin::class, 'index'])->name('about.index');
    Route::get('/about/edit', [AboutControllerAdmin::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutControllerAdmin::class, 'update'])->name('about.update');

    // Admin confirm (existing admin blade posts to this route)
    Route::post('/transactions/konfirmasi/{id}', [TransactionController::class, 'adminConfirm'])
        ->name('admin.transactions.konfirmasi');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')->middleware(['auth', RoleMiddleware::class . ':user'])->name('user.')->group(function () {
    // Dashboard & Produk
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Review
    Route::post('/review/store', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('review.store');

    Route::get('/language/{lang}', [LanguageController::class, 'switch'])->name('language.switch');
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{produk_id}', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');

    // Checkout & Transaksi
    Route::get('/checkout', [TransactionController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions/selesai/{id}', [TransactionController::class, 'terimaPesanan'])->name('transactions.selesai');

    // PDF Struk
    Route::get('/struk/{id}', [PDFController::class, 'cetakStruk'])->name('struk');

    // About (User)
    Route::get('/about', [AboutController::class, 'index'])->name('about');
});

/*
|--------------------------------------------------------------------------
| Endpoint to mark transaction completed (e.g., called by payment webhook or admin)
|--------------------------------------------------------------------------
*/
Route::post('/transactions/selesai/{id}', [TransactionController::class, 'markAsCompleted'])
    ->name('transactions.markSelesai');

/*
|--------------------------------------------------------------------------
| Chat Routes (Common for Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::post('/chatbot', [ChatController::class, 'chatbot'])->name('chat.chatbot');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
});

// Product detail routes (prevent 404 for /deskripsi/{id} and /produk/{id})
Route::get('/deskripsi/{id}', [ProductController::class, 'show'])->name('user.deskripsi');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('user.produk.show');

// API: product suggestions for search autosuggest (AJAX)
Route::get('/api/products/suggest', function (Request $request) {
    $q = trim($request->query('q', ''));
    if ($q === '') {
        return response()->json([]);
    }

    // adjust model / column names if different
    $matches = \App\Models\Produk::where('nama', 'like', '%' . $q . '%')
        ->select('id', 'nama', 'harga', 'foto')
        ->limit(8)
        ->get();

    $results = $matches->map(function ($p) {
        return [
            'id' => $p->id,
            'nama' => $p->nama,
            'harga' => $p->harga,
            'foto' => $p->foto ? asset('storage/' . $p->foto) : asset('images/placeholder.png'),
            'url' => \Illuminate\Support\Facades\Route::has('user.deskripsi')
                ? route('user.deskripsi', $p->id)
                : url('/deskripsi/' . $p->id),
        ];
    });

    return response()->json($results);
})->name('api.products.suggest');
