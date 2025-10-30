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

                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                            class="border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">

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

                                </div>
                            </div>
                        </div>
<div class="flex justify-between">

                                    <button type="submit" class="bg-blue-800 text-white px-3 py-1 rounded text-sm">Terapkan</button>
                                </div>
                        <button type="submit"
                            class="hidden">Cari</button> <!-- keep form structure; actual submit in panel -->
                    </div>
                </form>

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
                        <button onclick="toggleDropdown()" class="px-3 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-200">
                            Menu ⬇
                        </button>
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-40 bg-white text-blue-900 rounded-lg shadow-lg">
                            <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="button" onclick="confirmLogout(event)"
                                    class="w-full text-left px-4 py-2 hover:bg-blue-100">Logout</button>
                            </form>
                        </div>
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
                        class="w-full border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">

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
    </script>
</body>

</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/user.blade.php ENDPATH**/ ?>