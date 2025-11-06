<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Seilmu')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        /* Dark mode base */
        body {
            transition: background-color 0.3s ease;
        }

        body.dark-mode {
            background-color: #0f172a;
            color: #e2e8f0;
        }

        /* Dark mode overrides */
        .dark-mode .bg-white {
            background-color: #1e293b !important;
        }

        .dark-mode .text-gray-800 {
            color: #e2e8f0 !important;
        }

        .dark-mode .text-gray-600 {
            color: #cbd5e1 !important;
        }

        .dark-mode .text-gray-500 {
            color: #94a3b8 !important;
        }

        .dark-mode .text-gray-700 {
            color: #cbd5e1 !important;
        }

        .dark-mode .text-gray-900 {
            color: #f1f5f9 !important;
        }

        .dark-mode .text-black {
            color: #e2e8f0 !important;
        }

        .dark-mode .bg-blue-900 {
            background-color: #1e3a8a !important;
        }

        .dark-mode .bg-blue-800 {
            background-color: #1e40af !important;
        }

        .dark-mode .bg-blue-50 {
            background-color: #1e293b !important;
        }

        .dark-mode .bg-gray-50 {
            background-color: #1e293b !important;
        }

        .dark-mode .shadow-md,
        .dark-mode .shadow-lg,
        .dark-mode .shadow-xl,
        .dark-mode .shadow-2xl {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.6) !important;
        }

        .dark-mode .border-gray-300,
        .dark-mode .border-gray-200,
        .dark-mode .border {
            border-color: #334155 !important;
        }

        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        .dark-mode input::placeholder,
        .dark-mode select::placeholder,
        .dark-mode textarea::placeholder {
            color: #64748b !important;
        }

        .dark-mode .hover\:bg-gray-100:hover {
            background-color: #334155 !important;
        }

        .dark-mode .hover\:bg-blue-100:hover {
            background-color: #1e3a8a !important;
        }

        .dark-mode .hover\:bg-gray-50:hover {
            background-color: #334155 !important;
        }

        .dark-mode .hover\:bg-blue-50:hover {
            background-color: #1e3a8a !important;
        }

        .dark-mode .bg-gradient-to-r {
            background: linear-gradient(to right, #1e3a8a, #1e293b, #000) !important;
        }

        .dark-mode .bg-red-50 {
            background-color: #450a0a !important;
        }

        .dark-mode .hover\:bg-red-50:hover {
            background-color: #7f1d1d !important;
        }

        /* Modern dark mode toggle */
        .theme-toggle-btn {
            position: relative;
            width: 56px;
            height: 28px;
            background: #cbd5e1;
            border-radius: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 2px;
            transition: background 0.3s ease;
        }

        .theme-toggle-btn:hover {
            background: #94a3b8;
        }

        .dark-mode .theme-toggle-btn {
            background: #3b82f6;
        }

        .dark-mode .theme-toggle-btn:hover {
            background: #2563eb;
        }

        .theme-toggle-slider {
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .dark-mode .theme-toggle-slider {
            transform: translateX(28px);
        }

        /* Autosuggest box */
        .suggestions-container {
            max-height: 320px;
            overflow-y: auto;
        }

        .dark-mode .suggestions-container {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }

        .suggestion-item {
            padding: 0.5rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            cursor: pointer;
        }

        .suggestion-item:hover,
        .suggestion-item.active {
            background: #f1f5f9;
        }

        .dark-mode .suggestion-item:hover,
        .dark-mode .suggestion-item.active {
            background: #334155;
        }

        .suggestion-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
        }

        .suggestion-title {
            font-weight: 600;
            font-size: .95rem;
            color: #0f172a;
        }

        .dark-mode .suggestion-title {
            color: #e2e8f0;
        }

        .suggestion-sub {
            font-size: .825rem;
            color: #6b7280;
        }

        .dark-mode .suggestion-sub {
            color: #94a3b8;
        }

        /* Navbar improvements */
        nav {
            backdrop-filter: blur(10px);
        }

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark-mode ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-white text-gray-800">
    <?php
        use App\Models\Notification;

        $user = Auth::user();
        $isUser = Auth::check() && $user->role === 'user';

        $userNotifications = collect();
        $userNotifCount = 0;

        if ($isUser) {
            $userNotifications = Notification::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->with('sender')
                ->orderByDesc('created_at')
                ->take(6)
                ->get();
            $userNotifCount = $userNotifications->count();
        }

        $kategori = \App\Models\Kategori::all();
    ?>

    <div id="app">
        <!-- Modern Navbar -->
        <nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center relative">
                <!-- Branding -->
                <div class="flex items-center space-x-4">
                    <span class="text-2xl font-bold tracking-tight">
                        <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2">
                            <span class="text-3xl">📚</span>
                            <span>Seilmu</span>
                        </a>
                    </span>
                    <?php if(auth()->guard()->check()): ?>
                        <span class="hidden md:inline-block text-sm text-blue-200">Halo, <?php echo e(Auth::user()->name); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($isUser): ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="hover:text-blue-300 transition">Home</a>
                            <a href="<?php echo e(route('user.about')); ?>" class="hover:text-blue-300 transition">About</a>
                            <a href="<?php echo e(route('user.cart')); ?>" class="hover:text-blue-300 transition">Cart</a>
                            <a href="<?php echo e(route('user.transactions')); ?>" class="hover:text-blue-300 transition">History</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Chat with notifications -->
                    <div class="relative group">
                        <a href="<?php echo e(route('chat.index')); ?>" class="hover:text-blue-300 transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>Chat</span>

                            <?php if($userNotifCount > 0): ?>
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    <?php echo e($userNotifCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <?php if($isUser): ?>
                            <div class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 absolute right-0 mt-2 w-80 bg-white text-gray-800 rounded-xl shadow-2xl z-50">
                                <div class="p-3 border-b bg-blue-900 text-white font-semibold rounded-t-xl">
                                    Notifikasi
                                </div>

                                <?php if($userNotifications->isEmpty()): ?>
                                    <div class="p-4 text-sm text-gray-600">Tidak ada notifikasi baru.</div>
                                <?php else: ?>
                                    <ul class="max-h-64 overflow-auto">
                                        <?php $__currentLoopData = $userNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="hover:bg-gray-50 transition">
                                                <a href="<?php echo e(route('chat.show', $notif->sender_id)); ?>"
                                                    class="flex items-start p-3 space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium">
                                                            <?php echo e(strtoupper(substr($notif->sender->name ?? 'U', 0, 1))); ?>

                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-center">
                                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                                <?php echo e($notif->sender->name ?? 'User'); ?></p>
                                                            <p class="text-xs text-gray-500 ml-2 whitespace-nowrap">
                                                                <?php echo e($notif->created_at->diffForHumans()); ?>

                                                            </p>
                                                        </div>
                                                        <p class="text-sm text-gray-600 truncate">
                                                            <?php echo e(\Illuminate\Support\Str::limit($notif->message ?? 'Pesan baru', 80)); ?>

                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div class="p-2 border-t text-center">
                                        <a href="<?php echo e(route('chat.index')); ?>" class="text-sm text-blue-700 hover:underline">Lihat semua</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Search + Filters (Desktop) -->
                <form action="<?php echo e(route('user.dashboard')); ?>" method="GET" class="hidden md:flex items-center gap-2">
                    <select name="kategori" class="border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori') == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <div class="relative">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                            class="ajax-search border rounded-lg px-4 py-2 text-black focus:ring-2 focus:ring-blue-400 w-64"
                            autocomplete="off"
                            data-suggest-url="<?php echo e(route('api.products.suggest')); ?>">
                        <div class="suggestions-container hidden absolute mt-2 w-full bg-white border rounded-lg shadow-xl z-50" id="desktop-suggestions"></div>
                    </div>

                    <!-- Price sort dropdown -->
                    <div class="relative">
                        <button type="button" id="priceSortBtn"
                                class="flex items-center gap-2 border rounded-lg px-4 py-2 bg-white text-black hover:bg-gray-50 transition">
                            <span>Harga</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="priceSortPanel" class="hidden absolute right-0 mt-2 w-72 bg-white border rounded-lg shadow-xl p-4 z-50">
                            <div class="mb-3 text-sm text-gray-700 font-semibold">Urutkan:</div>

                            <div class="flex gap-3 mb-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="sort_harga" value="asc" class="form-radio text-blue-600"
                                        <?php echo e(request('sort_harga') == 'asc' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-800">Termurah</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="sort_harga" value="desc" class="form-radio text-blue-600"
                                        <?php echo e(request('sort_harga') == 'desc' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-800">Termahal</span>
                                </label>
                            </div>

                            <div class="mb-2 text-sm text-gray-600">Rentang Harga (Rp)</div>
                            <div class="flex gap-2 mb-4">
                                <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" min="0" step="1000"
                                       placeholder="Min" class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                                <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" min="0" step="1000"
                                       placeholder="Max" class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                            </div>

                            <div class="flex justify-between">
                                <button type="button" id="priceReset" class="text-sm text-gray-600 hover:text-gray-900">Reset</button>
                                <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Right side: Dark Mode + Auth -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <div class="theme-toggle-btn" onclick="toggleDarkMode()" title="Toggle dark mode">
                        <div class="theme-toggle-slider"></div>
                    </div>

                    <?php if(auth()->guard()->guest()): ?>
                        <div class="flex gap-2">
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100 transition">Login</a>
                            <?php endif; ?>
                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900 transition">Register</a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="relative">
                            <button onclick="toggleDropdown()"
                                class="px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-100 transition flex items-center gap-2">
                                Menu
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white text-blue-900 rounded-xl shadow-2xl overflow-hidden border z-50">
                                <a href="<?php echo e(route('user.wishlist')); ?>" class="block px-4 py-3 hover:bg-blue-50 transition text-sm font-medium">
                                    ❤️ Wishlist
                                </a>

                                <div class="border-t"></div>

                                <div class="px-4 py-3 text-sm">
                                    <div class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                        🌍 Pilih Bahasa
                                    </div>
                                    <div id="google_translate_element"></div>
                                </div>

                                <div class="border-t"></div>

                                <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" onclick="confirmLogout(event)"
                                        class="w-full text-left px-4 py-3 hover:bg-red-50 transition text-sm font-semibold text-red-600">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Hamburger (Mobile) -->
                <button class="md:hidden focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden bg-blue-800 text-white px-6 py-4 space-y-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="block hover:text-blue-300 transition">Home</a>
                    <a href="<?php echo e(route('user.about')); ?>" class="block hover:text-blue-300 transition">About</a>
                    <a href="<?php echo e(route('user.cart')); ?>" class="block hover:text-blue-300 transition">Cart</a>
                    <a href="<?php echo e(route('user.transactions')); ?>" class="block hover:text-blue-300 transition">History</a>
                    <a href="<?php echo e(route('chat.index')); ?>" class="block hover:text-blue-300 transition">
                        Chat
                        <?php if($userNotifCount > 0): ?>
                            <span class="inline-block bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-1"><?php echo e($userNotifCount); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <!-- Dark Mode Toggle Mobile -->
                <div class="flex items-center justify-between py-2 border-t border-blue-700 mt-3 pt-3">
                    <span class="text-sm">Mode Gelap</span>
                    <div class="theme-toggle-btn" onclick="toggleDarkMode()">
                        <div class="theme-toggle-slider"></div>
                    </div>
                </div>

                <!-- Mobile Search -->
                <form action="<?php echo e(route('user.dashboard')); ?>" method="GET" class="space-y-3 pt-2 border-t border-blue-700">
                    <select name="kategori" class="w-full border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori') == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <div class="relative">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                            class="ajax-search w-full border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400"
                            autocomplete="off"
                            data-suggest-url="<?php echo e(route('api.products.suggest')); ?>">
                        <div class="suggestions-container hidden mt-2 w-full bg-white border rounded-lg shadow-xl z-50" id="mobile-suggestions"></div>
                    </div>

                    <details class="bg-white text-black rounded-lg p-3">
                        <summary class="cursor-pointer font-medium">Harga & Filter</summary>
                        <div class="mt-3 space-y-3">
                            <div class="flex gap-3">
                                <label class="flex items-center">
                                    <input type="radio" name="sort_harga" value="asc" <?php echo e(request('sort_harga') == 'asc' ? 'checked' : ''); ?>>
                                    <span class="ml-2">Termurah</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="sort_harga" value="desc" <?php echo e(request('sort_harga') == 'desc' ? 'checked' : ''); ?>>
                                    <span class="ml-2">Termahal</span>
                                </label>
                            </div>

                            <div class="flex gap-2">
                                <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" min="0" step="1000"
                                       placeholder="Min Rp" class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                                <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" min="0" step="1000"
                                       placeholder="Max Rp" class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring-2 focus:ring-blue-400">
                            </div>

                            <button type="submit" class="w-full bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Terapkan</button>
                        </div>
                    </details>
                </form>

                <?php if(auth()->guard()->guest()): ?>
                    <div class="flex flex-col gap-2 border-t border-blue-700 pt-3 mt-3">
                        <?php if(Route::has('login')): ?>
                            <a href="<?php echo e(route('login')); ?>" class="block text-center px-4 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100 transition">Login</a>
                        <?php endif; ?>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="block text-center px-4 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900 transition">Register</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="border-t border-blue-700 pt-3 mt-3 space-y-2">
                        <a href="<?php echo e(route('user.wishlist')); ?>" class="block px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition">
                            ❤️ Wishlist
                        </a>

                        <div class="px-4 py-2 bg-white/10 rounded-lg">
                            <div class="text-sm font-semibold mb-2">🌍 Pilih Bahasa</div>
                            <div id="google_translate_element_mobile"></div>
                        </div>

                        <form id="logout-form-mobile" method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="button" onclick="confirmLogout(event)"
                                class="w-full text-left px-4 py-2 bg-red-500/20 rounded-lg hover:bg-red-500/30 transition font-semibold text-red-300">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

        <main class="w-full min-h-screen">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');

            // Also init mobile version if exists
            if (document.getElementById('google_translate_element_mobile')) {
                new google.translate.TranslateElement({
                    pageLanguage: 'id',
                    includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element_mobile');
            }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        // Dark Mode Toggle
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
        }

        // Load dark mode preference
        document.addEventListener('DOMContentLoaded', () => {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });

        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Keluar dari akun?',
                text: "Kamu akan keluar dari akun!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal',
                background: document.body.classList.contains('dark-mode') ? '#1e293b' : '#fff',
                color: document.body.classList.contains('dark-mode') ? '#e2e8f0' : '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form')?.submit();
                    document.getElementById('logout-form-mobile')?.submit();
                }
            });
        }

        // Price sort panel toggle
        (function(){
            const btn = document.getElementById('priceSortBtn');
            const panel = document.getElementById('priceSortPanel');
            const reset = document.getElementById('priceReset');

            if (btn && panel) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    panel.classList.toggle('hidden');
                });

                if (reset) {
                    reset.addEventListener('click', () => {
                        panel.querySelectorAll('input').forEach(i => {
                            if (i.type === 'radio') i.checked = false;
                            else i.value = '';
                        });
                    });
                }

                document.addEventListener('click', (e) => {
                    if (!panel.contains(e.target) && !btn.contains(e.target)) {
                        panel.classList.add('hidden');
                    }
                });
            }
        })();

        // Autosuggest
        (function(){
            const debounce = (fn, delay=300) => {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            };

            function createSuggestionItem(item) {
                const el = document.createElement('div');
                el.className = 'suggestion-item';
                el.tabIndex = 0;
                el.innerHTML = `
                    <img src="${item.foto}" class="suggestion-thumb" alt="${escapeHtml(item.nama)}">
                    <div>
                        <div class="suggestion-title">${escapeHtml(item.nama)}</div>
                        <div class="suggestion-sub">Rp ${Number(item.harga || 0).toLocaleString('id-ID')}</div>
                    </div>
                `;
                el.dataset.url = item.url;
                return el;
            }

            function escapeHtml(str){
                return String(str).replace(/[&<>"'`=\/]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;",'/':'&#47;','`':'&#96;','=':'&#61;'}[s]));
            }

            function attachAutosuggest(input, container) {
                const suggestUrl = input.dataset.suggestUrl;
                if (!suggestUrl) return;

                let activeIndex = -1;
                let items = [];

                const show = () => container.classList.remove('hidden');
                const hide = () => {
                    container.classList.add('hidden');
                    activeIndex = -1;
                    items = [];
                    container.innerHTML = '';
                };

                const setActive = (idx) => {
                    Array.from(container.children).forEach((n, i) => n.classList.toggle('active', i === idx));
                    activeIndex = idx;
                };

                const handleSelect = (idx) => {
                    const el = container.children[idx];
                    if (!el || !el.dataset.url) return;
                    window.location.href = el.dataset.url;
                };

                const fetchSuggestions = debounce(async (q) => {
                    if (!q || q.trim().length < 1) { hide(); return; }
                    try {
                        const res = await fetch(`${suggestUrl}?q=${encodeURIComponent(q)}`);
                        if (!res.ok) { hide(); return; }
                        const json = await res.json();
                        container.innerHTML = '';
                        if (!Array.isArray(json) || json.length === 0) { hide(); return; }
                        json.forEach(it => container.appendChild(createSuggestionItem(it)));
                        items = Array.from(container.children);
                        items.forEach((it, idx) => {
                            it.addEventListener('click', () => handleSelect(idx));
                            it.addEventListener('keydown', (e) => {
                                if (e.key === 'Enter') handleSelect(idx);
                            });
                        });
                        show();
                    } catch (err) {
                        hide();
                        console.error('Suggest error', err);
                    }
                }, 250);

                input.addEventListener('input', (e) => fetchSuggestions(e.target.value));

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (items.length === 0) return;
                        const next = (activeIndex + 1) % items.length;
                        setActive(next);
                        items[next].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (items.length === 0) return;
                        const prev = (activeIndex - 1 + items.length) % items.length;
                        setActive(prev);
                        items[prev].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'Enter') {
                        if (activeIndex >= 0) {
                            e.preventDefault();
                            handleSelect(activeIndex);
                        }
                    } else if (e.key === 'Escape') {
                        hide();
                    }
                });

                document.addEventListener('click', (ev) => {
                    if (!container.contains(ev.target) && ev.target !== input) hide();
                });

                input.addEventListener('blur', () => setTimeout(hide, 150));
            }

            document.addEventListener('DOMContentLoaded', () => {
                const desktopInput = document.querySelector('.ajax-search:not(.w-full)');
                const desktopContainer = document.getElementById('desktop-suggestions');
                if (desktopInput && desktopContainer) attachAutosuggest(desktopInput, desktopContainer);

                const mobileInput = document.querySelector('.ajax-search.w-full');
                const mobileContainer = document.getElementById('mobile-suggestions');
                if (mobileInput && mobileContainer) attachAutosuggest(mobileInput, mobileContainer);
            });
        })();

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#dropdownMenu') && !e.target.closest('button[onclick="toggleDropdown()"]')) {
                document.getElementById('dropdownMenu')?.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/user.blade.php ENDPATH**/ ?>