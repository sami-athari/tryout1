<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ReadHaus') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #0f15b3f7;
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col">
   @php
    $notif = false;
    if (Auth::check() && Auth::user()->role === 'user') {
        $key = 'has_new_message_for_user_' . Auth::id();
        $notif = session()->has($key);
    }
@endphp

    <div id="app" class="flex flex-col min-h-screen">
        <!-- Navbar -->
<nav class="bg-blue-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Kiri: Nama / Branding -->
            <div>
                @auth
                    <span class="text-2xl font-bold text-white">
                        {{ Auth::user()->name }}
                    </span>
                @else
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-white hover:text-blue-300">
                        {{ config('app.name', 'ReadHaus') }}
                    </a>
                @endauth
            </div>

            <!-- Tengah: Navigasi -->
            <div class="hidden sm:flex items-center space-x-6">
                @auth
                    @if (Auth::user()->role === 'user')
                        <a href="{{ route('user.dashboard') }}" class="text-white hover:text-blue-200 font-medium">🏠 Beranda</a>
                        <a href="{{ route('user.about') }}" class="text-white hover:text-blue-200 font-medium">Tentang Kami</a>
                        <a href="{{ route('user.cart') }}" class="text-white hover:text-blue-200 font-medium">🛒 Cart</a>
                        <a href="{{ route('user.transactions') }}" class="text-white hover:text-blue-200 font-medium">📜 Riwayat</a>
                    @endif
                @endauth

                <div class="relative">
                    <a href="{{ route('chat.index') }}" class="text-white hover:text-blue-200 font-medium relative">
                        💬 Pesan
                        @if ($notif)
                            <span class="absolute -top-1 -right-3 bg-red-600 text-xs rounded-full px-1.5 py-0.5">•</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Kanan: Auth -->
            <div class="relative">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-blue-700 font-semibold rounded hover:bg-blue-100 transition">
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded hover:bg-blue-100 transition">
                            Register
                        </a>
                    @endif
                @else
                    <button onclick="toggleDropdown()" class="inline-flex items-center text-white font-medium hover:text-blue-200">
                        ☰
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-blue-600 text-white z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-blue-500">
                                Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>


        <!-- Main Content -->
        <main class="flex-grow py-10 px-6">
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
