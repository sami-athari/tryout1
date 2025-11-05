<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Seilmu')); ?></title>

    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>

    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

   <?php
    $notif = false;
    if (Auth::check() && Auth::user()->role === 'user') {
        $key = 'has_new_message_for_user_' . Auth::id();
        $notif = session()->has($key);
    }
   ?>

    <div id="app">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Kiri: Nama / Branding -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold tracking-wide">
                        <a href="<?php echo e(url('/')); ?>">📚 Seilmu</a>
                    </span>
                    <?php if(auth()->guard()->check()): ?>
                        <span class="text-sm text-gray-300 italic">
                            Halo, <?php echo e(Auth::user()->name); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <!-- Tengah: Navigasi -->
                <div class="hidden md:flex space-x-6 text-lg">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role === 'user'): ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="hover:text-blue-300 transition">Home</a>
                            <a href="<?php echo e(route('user.about')); ?>" class="hover:text-blue-300 transition">About Us</a>
                            <a href="<?php echo e(route('user.cart')); ?>" class="hover:text-blue-300 transition">Cart</a>
                            <a href="<?php echo e(route('user.transactions')); ?>" class="hover:text-blue-300 transition">History</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                </div>

                <!-- Kanan: Auth -->
                <div class="relative">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="space-x-3">
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="px-3 py-2 rounded-lg bg-white text-blue-900 font-semibold hover:bg-gray-100 transition">Login</a>
                            <?php endif; ?>
                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>" class="px-3 py-2 rounded-lg border border-white hover:bg-white hover:text-blue-900 transition">Register</a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <button onclick="toggleDropdown()" class="px-3 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-200 transition">
                            Menu ⬇
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white text-blue-900 rounded-lg shadow-lg overflow-hidden">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-blue-100 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="w-full">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = event.target.closest('button');
            if (!dropdown.contains(event.target) && !button) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\SamiUSK\resources\views/layouts/app.blade.php ENDPATH**/ ?>