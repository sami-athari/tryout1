<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Seilmu') }} - Admin</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- tempat style tambahan dari child --}}
    @yield('styles')
</head>

<body class="bg-gray-100 text-gray-900">



    @yield('scripts')
@php
    $notifUsers = \App\Models\User::where('role', 'user')->get();
    $adminNotif = false;
    foreach ($notifUsers as $u) {
        if (session()->has('has_new_message_from_user_' . $u->id)) {
            $adminNotif = true;
            break;
        }
    }
@endphp

<div id="app" class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-900 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-wide hover:text-gray-200">
                {{ Auth::user()->name }} (📚 Seilmu)
            </a>

            <!-- Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300">Beranda</a>
                <a href="{{ route('admin.produk.index') }}" class="hover:text-gray-300">Produk</a>
                <a href="{{ route('admin.kategori.index') }}" class="hover:text-gray-300">Kategori</a>
                <a href="{{ route('admin.users.index') }}" class="hover:text-gray-300">Akun</a>
                <a href="{{ route('admin.transactions.index') }}" class="hover:text-gray-300">History</a>

                <!-- Pesan dengan notif -->
                <div class="relative">
                    <a href="{{ route('chat.index') }}" class="hover:text-gray-300">Pesan</a>
                    @if($adminNotif)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">!</span>
                    @endif
                </div>
            </div>

            <!-- Dropdown Mobile -->
            <div class="md:hidden relative">
                <button onclick="toggleMenu()" class="focus:outline-none">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div id="mobileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Beranda</a>
                    <a href="{{ route('admin.produk.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Produk</a>
                    <a href="{{ route('admin.kategori.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kategori</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Akun</a>
                    <a href="{{ route('admin.transactions.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">History</a>
                    <a href="{{ route('chat.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Pesan
                        @if($adminNotif) <span class="ml-2 text-red-600 font-bold">•</span> @endif
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Logout Desktop -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden md:block">
                @csrf
                <button type="submit" onclick="confirmLogout(event)"
                        class="ml-4 bg-red-600 hover:bg-red-500 px-3 py-1 rounded-md text-sm">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main -->
    <main class="flex-1 container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-6">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Seilmu') }}. Admin Panel.</p>
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
</script>
</body>
</html>
