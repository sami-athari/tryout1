<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Seilmu') }}</title>

    <!-- Prevent dark mode flicker -->
    <script>
        (function() {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
        .theme-switch { width: 50px; height: 26px; background: #e0e0e0; border-radius: 20px; cursor: pointer; position: relative; transition: 0.3s; }
        .dark-mode .theme-switch { background: #4a4a4a; }
        .theme-switch-slider { width: 20px; height: 20px; background: white; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: 0.3s; }
        .dark-mode .theme-switch-slider { left: 27px; }
    </style>
</head>

<body>
   @php
    $notif = false;
    if (Auth::check() && Auth::user()->role === 'user') {
        $key = 'has_new_message_for_user_' . Auth::id();
        $notif = session()->has($key);
    }
   @endphp

    <div id="app">
        <!-- Simple Navbar -->
        <nav class="bg-white border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-900">Seilmu</a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center gap-6">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Register</a>
                            @endif
                        @else
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                </button>
                                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg">
                                    <div class="p-4 border-b">
                                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <button onclick="confirmLogout(event)" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 border-t">Logout</button>
                                </div>
                            </div>
                        @endguest

                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="hidden md:hidden mt-4 space-y-4">
                    <div class="flex items-center justify-between py-2 border-t">
                        <span>Dark Mode</span>
                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>
                    </div>

                    @guest
                        <a href="{{ route('login') }}" class="block w-full text-center border py-2 rounded-lg">Login</a>
                        <a href="{{ route('register') }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg">Register</a>
                    @else
                        <button onclick="confirmLogout(event)" class="w-full text-left py-2 text-red-600">Logout</button>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="w-full min-h-screen">@yield('content')</main>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
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
