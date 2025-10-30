<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Seilmu')); ?> - Admin</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="bg-gray-100 text-gray-900">
    <?php
        use App\Models\User;
        use App\Models\Notification;

        $kategori = \App\Models\Kategori::all();
        $unreadNotifications = Notification::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();
        $unreadCount = $unreadNotifications->count();
    ?>


    <div id="app" class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md">
            <div class="container mx-auto flex justify-between items-center px-6 py-4 relative">
                <!-- Logo -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-xl font-bold tracking-wide hover:text-gray-200">
                    <?php echo e(Auth::user()->name); ?> (📚 Seilmu)
                </a>

                <!-- Tombol Hamburger (mobile) -->
                <button class="md:hidden text-white text-2xl focus:outline-none" onclick="toggleMenu()">
                    ☰
                </button>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-gray-300">Home</a>
                     <a href="<?php echo e(route('admin.about.index')); ?>" class="block hover:text-blue-300">About Us</a>
                    <a href="<?php echo e(route('admin.produk.index')); ?>" class="hover:text-gray-300">Product</a>
                    <a href="<?php echo e(route('admin.kategori.index')); ?>" class="hover:text-gray-300">Category</a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-gray-300">Accounts</a>
                    <a href="<?php echo e(route('admin.transactions.index')); ?>" class="hover:text-gray-300">History</a>

                    <!-- 🔔 Chat dengan teks dan notifikasi -->
                    <div class="relative group">
                        <a href="<?php echo e(route('chat.index')); ?>" class="relative hover:text-gray-300 flex items-center ">
                            Chat
                            <?php if($unreadCount > 0): ?>
                                <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    <?php echo e($unreadCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- Dropdown Pesan -->
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-64 bg-white text-gray-800 rounded-lg shadow-lg z-50">
                            <div class="p-3 border-b bg-blue-900 text-white font-semibold rounded-t-lg">
                                Pesan Baru
                            </div>
                            <ul class="max-h-60 overflow-y-auto">
                                <?php $__empty_1 = true; $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <a href="<?php echo e(route('chat.index', $notif->sender_id)); ?>"
                                           class="flex items-center px-3 py-2 hover:bg-gray-100 transition">
                                            <span class="font-medium text-blue-800"><?php echo e($notif->sender->name); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="px-3 py-2 text-sm text-gray-500 text-center">Tidak ada pesan baru</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>



                    <!-- Logout -->
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" onclick="confirmLogout(event)"
                                class="ml-2 bg-red-600 hover:bg-red-500 px-3 py-1 rounded-md text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="mobileMenu" class="hidden md:hidden flex flex-col space-y-2 px-6 pb-4 bg-blue-800">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-gray-300">Home</a>
                <a href="<?php echo e(route('admin.produk.index')); ?>" class="hover:text-gray-300">Product</a>
                <a href="<?php echo e(route('admin.kategori.index')); ?>" class="hover:text-gray-300">Category</a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-gray-300">Accounts</a>
                <a href="<?php echo e(route('admin.transactions.index')); ?>" class="hover:text-gray-300">History</a>

                <!-- Chat + Notif di Mobile -->
                <a href="<?php echo e(route('chat.index')); ?>" class="relative hover:text-gray-300 flex items-center">
                    Chat
                    <?php if($unreadCount > 0): ?>
                        <span class="absolute -top-1 -right-4 bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            <?php echo e($unreadCount); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <form id="logout-form-mobile" action="<?php echo e(route('logout')); ?>" method="POST" class="mt-3">
                    <?php echo csrf_field(); ?>
                    <button type="submit" onclick="confirmLogout(event)"
                            class="bg-red-600 hover:bg-red-500 px-3 py-1 rounded-md text-sm w-full text-left">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main -->
        <main class="flex-1 container mx-auto px-6 py-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-blue-900 text-white text-center py-6">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Seilmu')); ?>. Admin Panel.</p>
        </footer>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Keluar dari akun?',
                text: "Kamu akan keluar dari akun admin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (event.target.closest('form').id === 'logout-form-mobile') {
                        document.getElementById('logout-form-mobile').submit();
                    } else {
                        document.getElementById('logout-form').submit();
                    }
                }
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/layouts/admin.blade.php ENDPATH**/ ?>