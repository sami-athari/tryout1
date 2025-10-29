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
                                <!-- Badge merah bulat dengan angka -->
                                <span
                                    class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center animate-pulse">
                                    <?php echo e($userNotifCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- Dropdown notifikasi (desktop, muncul saat hover pada container .group) -->
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

                <!-- Search Desktop -->
                <form action="<?php echo e(route('user.dashboard')); ?>" method="GET" class="hidden md:flex items-center space-x-2">
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
                    <button type="submit"
                        class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
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

                <!-- Chat mobile (toggle list of notifs) -->
                <div class="relative">
                    <button onclick="toggleMobileChat()" class="w-full text-left hover:text-blue-300 flex items-center justify-between">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Chat</span>
                        </span>

                        <?php if($userNotifCount > 0): ?>
                            <span class="inline-flex items-center justify-center bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full">
                                <?php echo e($userNotifCount); ?>

                            </span>
                        <?php endif; ?>
                    </button>

                    <div id="mobileChatList" class="hidden mt-2 bg-blue-700 rounded p-2">
                        <?php if($userNotifications->isEmpty()): ?>
                            <div class="text-sm text-white px-2 py-1">Tidak ada notifikasi baru.</div>
                        <?php else: ?>
                            <?php $__currentLoopData = $userNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('chat.show', $notif->sender_id)); ?>"
                                    class="block px-2 py-2 rounded hover:bg-blue-600 text-white">
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="font-semibold"><?php echo e($notif->sender->name ?? 'User'); ?></div>
                                            <div class="text-xs truncate"><?php echo e(\Illuminate\Support\Str::limit($notif->message ?? '-', 60)); ?></div>
                                        </div>
                                        <div class="text-xs"><?php echo e($notif->created_at->diffForHumans()); ?></div>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Search Mobile -->
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
                    <button type="submit"
                        class="w-full bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
                </form>

                <!-- Auth Mobile -->
                <?php if(auth()->guard()->guest()): ?>
                    <div class="space-y-2">
                        <?php if(Route::has('login')): ?>
                            <a href="<?php echo e(route('login')); ?>"
                                class="block px-3 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100">Login</a>
                        <?php endif; ?>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>"
                                class="block px-3 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900">Register</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <form id="logout-form-mobile" method="POST" action="<?php echo e(route('logout')); ?>" class="pt-2">
                        <?php echo csrf_field(); ?>
                        <button type="button" onclick="confirmLogout(event)"
                            class="w-full bg-red-600 hover:bg-red-500 px-3 py-2 rounded-md">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Main Content -->
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

        function toggleMobileChat() {
            const el = document.getElementById('mobileChatList');
            if (!el) return;
            el.classList.toggle('hidden');
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

        // Optional: close dropdown when click outside
        document.addEventListener('click', function (e) {
            const group = document.querySelector('.group');
            if (!group) return;
            if (!group.contains(e.target)) {
                const dropdown = group.querySelector('[class*="group-hover"]');
                if (dropdown) {
                    dropdown.classList.remove('visible');
                }
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/user.blade.php ENDPATH**/ ?>