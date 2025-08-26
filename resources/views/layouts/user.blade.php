<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Seilmu') }}</title>

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Tailwind (kalau sudah dipakai di vite, ini bisa dihapus) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

   @php
    $notif = false;
    if (Auth::check() && Auth::user()->role === 'user') {
        $key = 'has_new_message_for_user_' . Auth::id();
        $notif = session()->has($key);
    }
   @endphp

    <div id="app">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Kiri: Nama / Branding -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold tracking-wide">
                        <a href="{{ url('/') }}">📚 Seilmu</a>
                    </span>
                    @auth
                        <span class="text-sm text-gray-300 italic">
                            Halo, {{ Auth::user()->name }}
                        </span>
                    @endauth
                </div>

                <!-- Tengah: Navigasi -->
                <div class="hidden md:flex space-x-6 text-lg">
                    @auth
                        @if (Auth::user()->role === 'user')
                            <a href="{{ route('user.dashboard') }}" class="hover:text-blue-300 transition">Beranda</a>
                            <a href="{{ route('user.about') }}" class="hover:text-blue-300 transition">Tentang Kami</a>
                            <a href="{{ route('user.cart') }}" class="hover:text-blue-300 transition">Keranjang</a>
                            <a href="{{ route('user.transactions') }}" class="hover:text-blue-300 transition">Riwayat</a>
                        @endif
                    @endauth

                    <a href="{{ route('chat.index') }}" class="hover:text-blue-300 transition relative">
                        Pesan
                        @if ($notif)
                            <span class="absolute -top-2 -right-3 bg-red-500 text-xs font-bold rounded-full px-2 py-0.5 animate-pulse">•</span>
                        @endif
                    </a>
                </div>

                <!-- Kanan: Auth -->
                <div class="relative">
                    @guest
                        <div class="space-x-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg bg-white text-blue-900 font-semibold hover:bg-gray-100 transition">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg border border-white hover:bg-white hover:text-blue-900 transition">Register</a>
                            @endif
                        </div>
                    @else
                        <button onclick="toggleDropdown()" class="px-3 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-200 transition">
                            Menu ⬇
                        </button>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white text-blue-900 rounded-lg shadow-lg overflow-hidden">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-blue-100 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="w-full">
            @yield('content')
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
