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
        /* Dark mode transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Dark mode classes */
        .dark-mode {
            background-color: #1a1a2e;
            color: #eee;
        }

        .dark-mode .bg-white {
            background-color: #16213e !important;
        }

        .dark-mode .text-gray-800 {
            color: #e4e4e4 !important;
        }

        .dark-mode .text-gray-600 {
            color: #b8b8b8 !important;
        }

        .dark-mode .text-gray-500 {
            color: #9a9a9a !important;
        }

        .dark-mode .bg-blue-900 {
            background-color: #0f3460 !important;
        }

        .dark-mode .shadow-md,
        .dark-mode .shadow-lg,
        .dark-mode .shadow-2xl {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5) !important;
        }

        .dark-mode .border-gray-300,
        .dark-mode .border {
            border-color: #374151 !important;
        }

        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #1f2937;
            color: #e4e4e4;
            border-color: #374151;
        }

        .dark-mode .hover\:bg-gray-100:hover {
            background-color: #1f2937 !important;
        }

        .dark-mode .hover\:bg-blue-100:hover {
            background-color: #1e3a5f !important;
        }

        /* Dark mode toggle button */
        .theme-toggle {
            position: relative;
            width: 60px;
            height: 30px;
            background: #ddd;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .dark-mode .theme-toggle {
            background: #4a5568;
        }

        .theme-toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .dark-mode .theme-toggle-slider {
            transform: translateX(30px);
            background: #1a202c;
        }

        /* autosuggest box */
        .suggestions-container {
            max-height: 320px;
            overflow-y: auto;
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

        .suggestion-sub {
            font-size: .825rem;
            color: #6b7280;
        }
    </style>
</head>

<body class="bg-white text-gray-800">
    <?php
        use App\Models\Notification;

        $user = Auth::user();
        $isUser = Auth::check() && $user->role === 'user';

        // Ambil notifikasi belum dibaca untuk user yang login (receiver_id = auth()->id())
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

        // kategori tetap dipakai
        $kategori = \App\Models\Kategori::all();
    ?>

    <div id="app">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center relative">
                <!-- Branding -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold">
                        <a href="<?php echo e(url('/')); ?>">📚 Seilmu</a>
                    </span>
                    <?php if(auth()->guard()->check()): ?>
                        <span class="text-sm text-gray-300 italic">Halo, <?php echo e(Auth::user()->name); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6 text-lg">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($isUser): ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="hover:text-blue-300">Home</a>
                            <a href="<?php echo e(route('user.about')); ?>" class="hover:text-blue-300">About Us</a>
                            <a href="<?php echo e(route('user.cart')); ?>" class="hover:text-blue-300">Cart</a>
                            <a href="<?php echo e(route('user.transactions')); ?>" class="hover:text-blue-300">History</a>

                        <?php endif; ?>
                    <?php endif; ?>



                    <!-- Chat dengan notifikasi untuk user -->
                    <div class="relative group">
                        <a href="<?php echo e(route('chat.index')); ?>" class="hover:text-blue-300 flex items-center">
                            <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Chat</span>

                            <?php if($userNotifCount > 0): ?>
                                <span
                                    class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center animate-pulse">
                                    <?php echo e($userNotifCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <?php if($isUser): ?>
                            <div
                                class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-150 absolute right-0 mt-2 w-80 bg-white text-gray-800 rounded-lg shadow-lg z-50 pointer-events-auto">
                                <div class="p-3 border-b bg-blue-900 text-white font-semibold rounded-t-lg">
                                    Notifikasi
                                </div>

                                <?php if($userNotifications->isEmpty()): ?>
                                    <div class="p-3 text-sm text-gray-600">Tidak ada notifikasi baru.</div>
                                <?php else: ?>
                                    <ul class="max-h-64 overflow-auto">
                                        <?php $__currentLoopData = $userNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="hover:bg-gray-100">
                                                <a href="<?php echo e(route('chat.show', $notif->sender_id)); ?>"
                                                    class="flex items-start p-3 space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium">
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
                                        <a href="<?php echo e(route('chat.index')); ?>" class="text-sm text-blue-700 hover:underline">Lihat
                                            semua chat</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Search + Kategori + Sortir Harga (Desktop) -->
                <form action="<?php echo e(route('user.dashboard')); ?>" method="GET" class="hidden md:flex md:flex-col items-start space-y-2">
                    <div class="flex items-center space-x-2">
                        <select name="kategori"
                            class="border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                            <option value="">Semua Kategori</option>
                            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori') == $k->id ? 'selected' : ''); ?>>
                                    <?php echo e($k->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <!-- Desktop search input: add class and data attribute -->
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                            class="ajax-search border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200"
                            autocomplete="off"
                            data-suggest-url="<?php echo e(route('api.products.suggest')); ?>">

                        <!-- suggestion container (desktop) -->
                        <div class="suggestions-container hidden absolute mt-12 w-80 bg-white border rounded shadow-lg z-50" id="desktop-suggestions"></div>

                        <!-- Replaced: sort select -> interactive dropdown with price inputs -->
                        <div class="relative">
                            <button type="button" id="priceSortBtn"
                                    class="flex items-center space-x-2 border rounded-lg px-3 py-2 bg-white text-black hover:shadow"
                                    aria-expanded="false">
                                <span>Urutkan Harga</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="priceSortPanel"
                                class="hidden absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50">
                                <div class="mb-2 text-sm text-gray-700 font-semibold">Urutkan:</div>

                                <div class="flex items-center gap-3 mb-3 text-gray-800">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="sort_harga" value="asc" class="form-radio text-blue-600"
                                            <?php echo e(request('sort_harga') == 'asc' ? 'checked' : ''); ?>>
                                        <span class="ml-2">Termurah</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="sort_harga" value="desc" class="form-radio text-blue-600"
                                            <?php echo e(request('sort_harga') == 'desc' ? 'checked' : ''); ?>>
                                        <span class="ml-2">Termahal</span>
                                    </label>
                                </div>
                                <div class="mb-3 text-sm text-gray-600">Rentang Harga (Rp)</div>
                                <div class="flex items-center space-x-2 mb-3">
                                    <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" min="0" step="1000"
                                           inputmode="numeric" placeholder="Min"
                                           class="w-1/2 border rounded-lg px-2 py-1 text-black focus:ring focus:ring-blue-200">
                                    <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" min="0" step="1000"
                                           inputmode="numeric" placeholder="Max"
                                           class="w-1/2 border rounded-lg px-2 py-1 text-black focus:ring focus:ring-blue-200">
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" id="priceReset" class="text-sm text-gray-600 hover:underline">Reset</button>
                                    <button type="submit" class="bg-blue-800 text-white px-3 py-1 rounded text-sm">Terapkan</button>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="hidden">Cari</button>
                    </div>
                </form>

                <!-- Dark Mode Toggle -->
                    <div class="flex items-center space-x-2">
                        <div class="theme-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                            <div class="theme-toggle-slider">
                                <span id="themeIcon">☀️</span>
                            </div>
                        </div>
                    </div>

                <!-- Auth Desktop -->
                <div class="hidden md:block">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="space-x-3">
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>"
                                    class="px-3 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100">Login</a>
                            <?php endif; ?>
                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>"
                                    class="px-3 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900">Register</a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                       <!-- Dropdown Menu -->
                <?php if(auth()->guard()->check()): ?>
                    <div class="relative">
                        <button onclick="toggleDropdown()"
                            class="px-3 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-200 flex items-center">
                            Menu ⬇
                        </button>
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-60 bg-white text-blue-900 rounded-xl shadow-xl overflow-hidden border border-gray-200 z-50">
                            <a href="<?php echo e(route('user.wishlist')); ?>"
                                class="block px-4 py-2 hover:bg-blue-100 text-sm font-medium">
                                ❤️ Wishlist
                            </a>

                            <div class="border-t border-gray-200 my-1"></div>

                            <!-- Bahasa Section -->
                            <div class="px-4 py-3 text-sm font-medium space-y-2">
                                <div class="text-gray-700 font-semibold flex items-center gap-2">
                                    🌍 Pilih Bahasa
                                </div>
                                <div id="google_translate_element" class="w-full"></div>
                            </div>

                            <div class="border-t border-gray-200 my-1"></div>

                            <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="button" onclick="confirmLogout(event)"
                                    class="w-full text-left px-4 py-2 hover:bg-blue-100 text-sm font-semibold text-red-600">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                    <?php endif; ?>
                </div>

                <!-- Hamburger (Mobile) -->
                <button class="md:hidden focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden bg-blue-800 text-white px-6 py-4 space-y-4">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('user.dashboard')); ?>" class="block hover:text-blue-300">Home</a>
                    <a href="<?php echo e(route('user.about')); ?>" class="block hover:text-blue-300">About Us</a>
                    <a href="<?php echo e(route('user.cart')); ?>" class="block hover:text-blue-300">Cart</a>
                    <a href="<?php echo e(route('user.transactions')); ?>" class="block hover:text-blue-300">History</a>


                <?php endif; ?>
                 <!-- Google Translate Script -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                <!-- Dark Mode Toggle Mobile -->
                <div class="flex items-center justify-between py-2">
                    <span>Dark Mode</span>
                    <div class="theme-toggle" onclick="toggleDarkMode()">
                        <div class="theme-toggle-slider">
                            <span id="themeIconMobile">☀️</span>
                        </div>
                    </div>
                </div>

                <!-- Search Mobile + Sortir Harga -->
                <form action="<?php echo e(route('user.dashboard')); ?>" method="GET" class="space-y-2">
                    <select name="kategori"
                        class="w-full border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori') == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                        class="ajax-search w-full border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200"
                        autocomplete="off"
                        data-suggest-url="<?php echo e(route('api.products.suggest')); ?>">

                    <!-- suggestion container (mobile) -->
                    <div class="suggestions-container hidden mt-2 w-full bg-white border rounded shadow-lg z-50" id="mobile-suggestions"></div>

                    <!-- Mobile: collapse-able panel for sort + price -->
                    <details class="bg-white text-black rounded-lg p-2">
                        <summary class="cursor-pointer px-2 py-1">Urutkan Harga & Filter</summary>

                        <div class="mt-2 space-y-2">
                            <div class="flex items-center gap-3">
                                <label><input type="radio" name="sort_harga" value="asc" <?php echo e(request('sort_harga') == 'asc' ? 'checked' : ''); ?>> <span class="ml-1">Termurah</span></label>
                                <label><input type="radio" name="sort_harga" value="desc" <?php echo e(request('sort_harga') == 'desc' ? 'checked' : ''); ?>> <span class="ml-1">Termahal</span></label>
                            </div>

                            <div class="flex gap-2">
                                <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" min="0" step="1000"
                                       inputmode="numeric" placeholder="Min Rp"
                                       class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                                <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" min="0" step="1000"
                                       inputmode="numeric" placeholder="Max Rp"
                                       class="w-1/2 border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                            </div>

                            <div class="flex justify-between">
                                <button type="reset" class="text-sm text-gray-700">Reset</button>
                                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg">Terapkan</button>
                            </div>
                        </div>
                    </details>

                    <button type="submit"
                        class="w-full bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
                </form>
            </div>
        </nav>

        <main class="w-full">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script>
        // Dark Mode Functions
        function toggleDarkMode() {
            const body = document.body;
            const isDark = body.classList.toggle('dark-mode');

            // Update icons
            const icon = document.getElementById('themeIcon');
            const iconMobile = document.getElementById('themeIconMobile');

            if (isDark) {
                icon.textContent = '🌙';
                if (iconMobile) iconMobile.textContent = '🌙';
                localStorage.setItem('darkMode', 'enabled');
            } else {
                icon.textContent = '☀️';
                if (iconMobile) iconMobile.textContent = '☀️';
                localStorage.setItem('darkMode', 'disabled');
            }
        }

        // Load dark mode preference on page load
        (function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
                const icon = document.getElementById('themeIcon');
                const iconMobile = document.getElementById('themeIconMobile');
                if (icon) icon.textContent = '🌙';
                if (iconMobile) iconMobile.textContent = '🌙';
            }
        })();

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
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form')?.submit();
                    document.getElementById('logout-form-mobile')?.submit();
                }
            });
        }

        // Toggle desktop price sort panel
        (function(){
            const btn = document.getElementById('priceSortBtn');
            const panel = document.getElementById('priceSortPanel');
            const reset = document.getElementById('priceReset');

            if (btn && panel) {
                btn.addEventListener('click', () => {
                    const open = panel.classList.toggle('hidden') === false;
                    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                });

                // Reset inputs inside the panel
                if (reset) {
                    reset.addEventListener('click', () => {
                        panel.querySelectorAll('input').forEach(i => {
                            if (i.type === 'radio') i.checked = false;
                            else i.value = '';
                        });
                    });
                }

                // Close panel when clicking outside
                document.addEventListener('click', (e) => {
                    if (!panel.contains(e.target) && !btn.contains(e.target)) {
                        panel.classList.add('hidden');
                        btn.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        })();

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

    function escapeHtml(str){ return String(str).replace(/[&<>"'`=\/]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;",'/':'&#47;','`':'&#96;','=':'&#61;'}[s])); }

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
            const nodes = Array.from(container.children);
            nodes.forEach((n, i) => n.classList.toggle('active', i === idx));
            activeIndex = idx;
        };

        const handleSelect = (idx) => {
            const el = container.children[idx];
            if (!el) return;
            const url = el.dataset.url;
            // navigate to product page
            if (url) window.location.href = url;
        };

        const fetchSuggestions = debounce(async (q) => {
            if (!q || q.trim().length < 1) { hide(); return; }
            try {
                const res = await fetch(`${suggestUrl}?q=${encodeURIComponent(q)}`, { credentials: 'same-origin' });
                if (!res.ok) { hide(); return; }
                const json = await res.json();
                container.innerHTML = '';
                if (!Array.isArray(json) || json.length === 0) { hide(); return; }
                json.forEach(it => container.appendChild(createSuggestionItem(it)));
                items = Array.from(container.children);
                // click handlers
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

        input.addEventListener('input', (e) => {
            const q = e.target.value;
            fetchSuggestions(q);
        });

        input.addEventListener('keydown', (e) => {
            const key = e.key;
            if (key === 'ArrowDown') {
                e.preventDefault();
                if (items.length === 0) return;
                const next = (activeIndex + 1) % items.length;
                setActive(next);
                items[next].scrollIntoView({ block: 'nearest' });
            } else if (key === 'ArrowUp') {
                e.preventDefault();
                if (items.length === 0) return;
                const prev = (activeIndex - 1 + items.length) % items.length;
                setActive(prev);
                items[prev].scrollIntoView({ block: 'nearest' });
            } else if (key === 'Enter') {
                if (activeIndex >= 0) {
                    e.preventDefault();
                    handleSelect(activeIndex);
                }
            } else if (key === 'Escape') {
                hide();
            }
        });

        // hide on outside click
        document.addEventListener('click', (ev) => {
            if (!container.contains(ev.target) && ev.target !== input) hide();
        });

        // hide on blur with slight delay to allow click
        input.addEventListener('blur', () => setTimeout(hide, 150));
    }

    // attach to desktop and mobile inputs
    document.addEventListener('DOMContentLoaded', () => {
        const desktopInput = document.querySelector('.ajax-search:not([data-mobile])'); // first desktop
        const desktopContainer = document.getElementById('desktop-suggestions');
        if (desktopInput && desktopContainer) attachAutosuggest(desktopInput, desktopContainer);

        const mobileInput = document.querySelector('.ajax-search[data-mobile="1"]') || document.querySelector('.ajax-search.w-full');
        const mobileContainer = document.getElementById('mobile-suggestions');
        if (mobileInput && mobileContainer) attachAutosuggest(mobileInput, mobileContainer);

        // If desktop input exists but no explicit mobile marker, also try to attach for other .ajax-search inputs
        document.querySelectorAll('.ajax-search').forEach((inp) => {
            if (inp === desktopInput || inp === mobileInput) return;
            // create sibling container if not present
            let container = inp.parentElement.querySelector('.suggestions-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'suggestions-container hidden mt-2 w-full bg-white border rounded shadow-lg z-50';
                inp.parentElement.appendChild(container);
            }
            attachAutosuggest(inp, container);
        });
    });
})();
    </script>
</body>

</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/user.blade.php ENDPATH**/ ?>