<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Seilmu') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-white text-gray-800">
    @php
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
    @endphp

    <div id="app">
        <!-- Navbar -->
        <nav class="bg-blue-900 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center relative">
                <!-- Branding -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-bold">
                        <a href="{{ url('/') }}">📚 Seilmu</a>
                    </span>
                    @auth
                        <span class="text-sm text-gray-300 italic">Halo, {{ Auth::user()->name }}</span>
                    @endauth
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6 text-lg">
                    @auth
                        @if ($isUser)
                            <a href="{{ route('user.dashboard') }}" class="hover:text-blue-300">Home</a>
                            <a href="{{ route('user.about') }}" class="hover:text-blue-300">About Us</a>
                            <a href="{{ route('user.cart') }}" class="hover:text-blue-300">Cart</a>
                            <a href="{{ route('user.transactions') }}" class="hover:text-blue-300">History</a>
                        @endif
                    @endauth

                    <!-- Chat dengan notifikasi untuk user -->
                    <div class="relative group">
                        <a href="{{ route('chat.index') }}" class="hover:text-blue-300 flex items-center">
                            <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Chat</span>

                            @if ($userNotifCount > 0)
                                <!-- Badge merah bulat dengan angka -->
                                <span
                                    class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center animate-pulse">
                                    {{ $userNotifCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Dropdown notifikasi (desktop, muncul saat hover pada container .group) -->
                        @if ($isUser)
                            <div
                                class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-150 absolute right-0 mt-2 w-80 bg-white text-gray-800 rounded-lg shadow-lg z-50 pointer-events-auto">
                                <div class="p-3 border-b bg-blue-900 text-white font-semibold rounded-t-lg">
                                    Notifikasi
                                </div>

                                @if ($userNotifications->isEmpty())
                                    <div class="p-3 text-sm text-gray-600">Tidak ada notifikasi baru.</div>
                                @else
                                    <ul class="max-h-64 overflow-auto">
                                        @foreach ($userNotifications as $notif)
                                            <li class="hover:bg-gray-100">
                                                <a href="{{ route('chat.show', $notif->sender_id) }}"
                                                    class="flex items-start p-3 space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium">
                                                            {{ strtoupper(substr($notif->sender->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-center">
                                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                                {{ $notif->sender->name ?? 'User' }}</p>
                                                            <p class="text-xs text-gray-500 ml-2 whitespace-nowrap">
                                                                {{ $notif->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                        <p class="text-sm text-gray-600 truncate">
                                                            {{ \Illuminate\Support\Str::limit($notif->message ?? 'Pesan baru', 80) }}
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="p-2 border-t text-center">
                                        <a href="{{ route('chat.index') }}" class="text-sm text-blue-700 hover:underline">Lihat
                                            semua chat</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Search Desktop -->
                <form action="{{ route('user.dashboard') }}" method="GET" class="hidden md:flex items-center space-x-2">
                    <select name="kategori"
                        class="border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                    <button type="submit"
                        class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
                </form>

                <!-- Auth Desktop -->
                <div class="hidden md:block">
                    @guest
                        <div class="space-x-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}"
                                    class="px-3 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-3 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900">Register</a>
                            @endif
                        </div>
                    @else
                        <button onclick="toggleDropdown()" class="px-3 py-2 bg-white text-blue-900 rounded-lg hover:bg-gray-200">
                            Menu ⬇
                        </button>
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-40 bg-white text-blue-900 rounded-lg shadow-lg">
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button" onclick="confirmLogout(event)"
                                    class="w-full text-left px-4 py-2 hover:bg-blue-100">Logout</button>
                            </form>
                        </div>
                    @endguest
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
                @auth
                    <a href="{{ route('user.dashboard') }}" class="block hover:text-blue-300">Home</a>
                    <a href="{{ route('user.about') }}" class="block hover:text-blue-300">About Us</a>
                    <a href="{{ route('user.cart') }}" class="block hover:text-blue-300">Cart</a>
                    <a href="{{ route('user.transactions') }}" class="block hover:text-blue-300">History</a>
                @endauth

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

                        @if ($userNotifCount > 0)
                            <span class="inline-flex items-center justify-center bg-red-500 text-white text-xs font-bold w-6 h-6 rounded-full">
                                {{ $userNotifCount }}
                            </span>
                        @endif
                    </button>

                    <div id="mobileChatList" class="hidden mt-2 bg-blue-700 rounded p-2">
                        @if ($userNotifications->isEmpty())
                            <div class="text-sm text-white px-2 py-1">Tidak ada notifikasi baru.</div>
                        @else
                            @foreach ($userNotifications as $notif)
                                <a href="{{ route('chat.show', $notif->sender_id) }}"
                                    class="block px-2 py-2 rounded hover:bg-blue-600 text-white">
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="font-semibold">{{ $notif->sender->name ?? 'User' }}</div>
                                            <div class="text-xs truncate">{{ \Illuminate\Support\Str::limit($notif->message ?? '-', 60) }}</div>
                                        </div>
                                        <div class="text-xs">{{ $notif->created_at->diffForHumans() }}</div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Search Mobile -->
                <form action="{{ route('user.dashboard') }}" method="GET" class="space-y-2">
                    <select name="kategori"
                        class="w-full border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="w-full border rounded-lg px-3 py-2 text-black focus:ring focus:ring-blue-200">
                    <button type="submit"
                        class="w-full bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
                </form>

                <!-- Auth Mobile -->
                @guest
                    <div class="space-y-2">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                                class="block px-3 py-2 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100">Login</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="block px-3 py-2 border border-white rounded-lg hover:bg-white hover:text-blue-900">Register</a>
                        @endif
                    </div>
                @else
                    <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="button" onclick="confirmLogout(event)"
                            class="w-full bg-red-600 hover:bg-red-500 px-3 py-2 rounded-md">Logout</button>
                    </form>
                @endguest
            </div>
        </nav>

        <!-- Main Content -->
        <main class="w-full">
            @yield('content')
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
