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
    <?php echo $__env->yieldContent('scripts'); ?>
    <?php
        $notifUsers = \App\Models\User::where('role', 'user')->get();
        $adminNotif = false;
        foreach ($notifUsers as $u) {
            if (session()->has('has_new_message_from_user_' . $u->id)) {
                $adminNotif = true;
                break;
            }
        }
    ?>

    <div id="app" class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md">
            <div class="container mx-auto flex justify-between items-center px-6 py-4">
                <!-- Logo -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-xl font-bold tracking-wide hover:text-gray-200">
                    <?php echo e(Auth::user()->name); ?> (📚 Seilmu)
                </a>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-gray-300">Home</a>
                    <a href="<?php echo e(route('admin.produk.index')); ?>" class="hover:text-gray-300">Product</a>
                    <a href="<?php echo e(route('admin.kategori.index')); ?>" class="hover:text-gray-300">Category</a>

<a href="<?php echo e(route('admin.about.index')); ?>" class="hover:text-gray-300">About</a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-gray-300">Accounts</a>
                    <a href="<?php echo e(route('admin.transactions.index')); ?>" class="hover:text-gray-300">History</a>

                    <!-- Pesan dengan notif -->
                    <div class="relative">
                        <a href="<?php echo e(route('chat.index')); ?>" class="hover:text-gray-300">Chat</a>
                        <?php if($adminNotif): ?>
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">!</span>
                        <?php endif; ?>
                    </div>
                </div>

                 <!-- Search Produk + Kategori -->
                <form action="<?php echo e(route('admin.produk.index')); ?>" method="GET" class="flex items-center space-x-2">
                    <?php $kategori = \App\Models\Kategori::all(); ?>
                    <!-- Dropdown Kategori -->
                    <select name="kategori"
                        class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none text-black">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e((int) request()->input('kategori') === $k->id ? 'selected' : ''); ?>>
    <?php echo e($k->nama); ?>

</option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <!-- Input Search -->
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                        class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none text-black">

                    <!-- Tombol -->
                    <button type="submit"
                        class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Cari
                    </button>
                </form>


                <!-- Logout Desktop -->
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden md:block">
                    <?php echo csrf_field(); ?>
                    <button type="submit" onclick="confirmLogout(event)"
                            class="ml-4 bg-red-600 hover:bg-red-500 px-3 py-1 rounded-md text-sm">
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
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Auto scroll ke produk kalau ada parameter search
        document.addEventListener("DOMContentLoaded", function () {
            const params = new URLSearchParams(window.location.search);
            if (params.has("search") && params.get("search").trim() !== "") {
                const produkSection = document.getElementById("produk");
                if (produkSection) {
                    produkSection.scrollIntoView({ behavior: "smooth" });
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/admin.blade.php ENDPATH**/ ?>