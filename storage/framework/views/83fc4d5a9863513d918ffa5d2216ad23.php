<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Seilmu')); ?> - Admin</title>

    <!-- Prevent dark mode flicker -->
    <script>
        (function() {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: background-color 0.2s, color 0.2s; }
        .dark-mode { background: #1a1a1a; color: #e5e5e5; }
        .dark-mode .bg-white { background: #2a2a2a !important; }
        .dark-mode .text-gray-900 { color: #e5e5e5 !important; }
        .dark-mode .text-gray-800 { color: #d4d4d4 !important; }
        .dark-mode .text-gray-700 { color: #b0b0b0 !important; }
        .dark-mode .text-gray-600 { color: #9ca3af !important; }
        .dark-mode .text-gray-500 { color: #6b7280 !important; }
        .dark-mode .border-gray-200 { border-color: #3a3a3a !important; }
        .dark-mode .border { border-color: #3a3a3a !important; }
        .dark-mode .bg-gray-50 { background: #1f1f1f !important; }
        .dark-mode .bg-gray-100 { background: #2f2f2f !important; }
        .dark-mode .bg-gray-200 { background: #3a3a3a !important; }
        .dark-mode input, .dark-mode select, .dark-mode textarea { background: #2a2a2a !important; color: #e5e5e5 !important; border-color: #3a3a3a !important; }
        .dark-mode .hover\:bg-gray-50:hover { background: #2f2f2f !important; }
        .dark-mode .hover\:bg-gray-100:hover { background: #3a3a3a !important; }
        .dark-mode nav.bg-white { background: #1a1a1a !important; border-color: #3a3a3a !important; }
        .dark-mode table tr { border-color: #3a3a3a !important; }
        .dark-mode table tbody tr:hover { background: #2f2f2f !important; }
        .theme-switch { width: 50px; height: 26px; background: #e0e0e0; border-radius: 20px; cursor: pointer; position: relative; transition: 0.3s; }
        .dark-mode .theme-switch { background: #4a4a4a; }
        .theme-switch-slider { width: 20px; height: 20px; background: white; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: 0.3s; }
        .dark-mode .theme-switch-slider { left: 27px; }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <?php
        use App\Models\Notification;
        $unreadNotifications = Notification::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();
        $unreadCount = $unreadNotifications->count();
    ?>

    <div id="app">
        <!-- Simple Navbar -->
        <nav class="bg-white border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-2xl font-bold text-gray-900">Seilmu Admin</a>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center gap-6">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-gray-900">Home</a>
                        <a href="<?php echo e(route('admin.about.index')); ?>" class="text-gray-700 hover:text-gray-900">About</a>
                        <a href="<?php echo e(route('admin.produk.index')); ?>" class="text-gray-700 hover:text-gray-900">Products</a>
                        <a href="<?php echo e(route('admin.kategori.index')); ?>" class="text-gray-700 hover:text-gray-900">Categories</a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-gray-700 hover:text-gray-900">Users</a>
                        <a href="<?php echo e(route('admin.transactions.index')); ?>" class="text-gray-700 hover:text-gray-900">Orders</a>

                        <!-- Chat with notifications -->
                        <div class="relative group">
                            <a href="<?php echo e(route('chat.index')); ?>" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                                Chat
                                <?php if($unreadCount > 0): ?>
                                    <span class="bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center"><?php echo e($unreadCount); ?></span>
                                <?php endif; ?>
                            </a>

                            <!-- Dropdown Messages -->
                            <div class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg">
                                <div class="p-4 border-b font-semibold">New Messages</div>
                                <?php if($unreadNotifications->isEmpty()): ?>
                                    <div class="p-6 text-center text-gray-500">No new messages</div>
                                <?php else: ?>
                                    <ul class="max-h-60 overflow-y-auto">
                                        <?php $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a href="<?php echo e(route('chat.index', $notif->sender_id)); ?>" class="flex items-center p-3 hover:bg-gray-50">
                                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold"><?php echo e(strtoupper(substr($notif->sender->name ?? 'U', 0, 1))); ?></div>
                                                    <div class="ml-3">
                                                        <p class="font-semibold text-sm"><?php echo e($notif->sender->name ?? 'User'); ?></p>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="hidden lg:flex items-center gap-4">
                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>

                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
                            </button>
                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg">
                                <div class="p-4 border-b">
                                    <p class="font-semibold"><?php echo e(Auth::user()->name); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                                </div>
                                <button onclick="confirmLogout(event)" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 border-t">Logout</button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="hidden lg:hidden mt-4 space-y-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block py-2">Home</a>
                    <a href="<?php echo e(route('admin.about.index')); ?>" class="block py-2">About</a>
                    <a href="<?php echo e(route('admin.produk.index')); ?>" class="block py-2">Products</a>
                    <a href="<?php echo e(route('admin.kategori.index')); ?>" class="block py-2">Categories</a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="block py-2">Users</a>
                    <a href="<?php echo e(route('admin.transactions.index')); ?>" class="block py-2">Orders</a>
                    <a href="<?php echo e(route('chat.index')); ?>" class="block py-2">Chat <?php if($unreadCount > 0): ?><span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"><?php echo e($unreadCount); ?></span><?php endif; ?></a>

                    <div class="flex items-center justify-between py-2 border-t">
                        <span>Dark Mode</span>
                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>
                    </div>

                    <button onclick="confirmLogout(event)" class="w-full text-left py-2 text-red-600">Logout</button>
                </div>
            </div>
        </nav>

        <main class="w-full min-h-screen"><?php echo $__env->yieldContent('content'); ?></main>
        <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" class="hidden"><?php echo csrf_field(); ?></form>
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                document.documentElement.classList.add('dark-mode');
            }
        });
        function toggleDropdown() { document.getElementById('dropdownMenu').classList.toggle('hidden'); }
        function toggleMobileMenu() { document.getElementById('mobileMenu').classList.toggle('hidden'); }
        function confirmLogout(e) {
            e.preventDefault();
            Swal.fire({title: 'Logout?', text: "Are you sure?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#3b82f6', cancelButtonColor: '#ef4444', confirmButtonText: 'Yes', cancelButtonText: 'Cancel'}).then((result) => {
                if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/layouts/admin.blade.php ENDPATH**/ ?>