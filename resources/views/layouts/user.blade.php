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

    <style>
        /* Modern CSS Reset & Smooth Transitions */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            background-color: #ffffff;
            color: #1f2937;
        }

        /* Dark Mode */
        body.dark-mode {
            background: linear-gradient(to bottom right, #0f172a, #1e293b);
            color: #e2e8f0;
        }

        /* Glassmorphism for navbar */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .dark-mode .glass-nav {
            background: rgba(30, 41, 59, 0.8);
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #6366f1);
            border-radius: 10px;
        }

        .dark-mode ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #1e40af, #4338ca);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #4f46e5);
        }

        /* Dark Mode Toggle Switch */
        .theme-switch {
            position: relative;
            width: 60px;
            height: 30px;
            background: #e5e7eb;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .theme-switch:hover {
            background: #d1d5db;
        }

        .dark-mode .theme-switch {
            background: #3b82f6;
        }

        .dark-mode .theme-switch:hover {
            background: #2563eb;
        }

        .theme-switch-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dark-mode .theme-switch-slider {
            transform: translateX(30px);
        }

        /* Icon transitions */
        .sun-icon, .moon-icon {
            width: 14px;
            height: 14px;
            position: absolute;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .sun-icon {
            opacity: 1;
            transform: scale(1);
        }

        .moon-icon {
            opacity: 0;
            transform: scale(0);
        }

        .dark-mode .sun-icon {
            opacity: 0;
            transform: scale(0);
        }

        .dark-mode .moon-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* Dropdown animations */
        .dropdown-enter {
            animation: dropdown-enter 0.3s ease-out;
        }

        @keyframes dropdown-enter {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Notification badge pulse */
        .notif-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Search input focus effect */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dark-mode .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Suggestions container */
        .suggestions-container {
            max-height: 400px;
            overflow-y: auto;
            animation: dropdown-enter 0.2s ease-out;
        }

        .dark-mode .suggestions-container {
            background: rgba(30, 41, 59, 0.95) !important;
            backdrop-filter: blur(12px);
            border-color: #334155 !important;
        }

        .suggestion-item {
            transition: all 0.2s ease;
        }

        .suggestion-item:hover {
            background: #f3f4f6;
            transform: translateX(4px);
        }

        .dark-mode .suggestion-item:hover {
            background: #334155;
        }

        /* Mobile menu slide */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu.active {
            max-height: 1000px;
        }

        /* Button hover effects */
        .btn-primary {
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Dark mode text colors */
        .dark-mode .text-gray-900 {
            color: #e2e8f0 !important;
        }

        .dark-mode .text-gray-800 {
            color: #cbd5e1 !important;
        }

        .dark-mode .text-gray-700 {
            color: #94a3b8 !important;
        }

        .dark-mode .text-gray-600 {
            color: #64748b !important;
        }

        .dark-mode .text-gray-500 {
            color: #475569 !important;
        }

        /* Dark mode backgrounds */
        .dark-mode .bg-white {
            background-color: #1e293b !important;
        }

        .dark-mode .bg-gray-50 {
            background-color: #0f172a !important;
        }

        .dark-mode .bg-gray-100 {
            background-color: #1e293b !important;
        }

        /* Dark mode borders */
        .dark-mode .border-gray-200,
        .dark-mode .border-gray-300,
        .dark-mode .border {
            border-color: #334155 !important;
        }

        /* Dark mode inputs */
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        .dark-mode input::placeholder {
            color: #64748b !important;
        }

        /* Dark mode hover states */
        .dark-mode .hover\:bg-gray-50:hover {
            background-color: #334155 !important;
        }

        .dark-mode .hover\:bg-gray-100:hover {
            background-color: #334155 !important;
        }

        .dark-mode .hover\:bg-blue-50:hover {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .dark-mode .hover\:bg-red-50:hover {
            background-color: rgba(239, 68, 68, 0.1) !important;
        }
    </style>
</head>

<body>
    @php
        use App\Models\Notification;

        $user = Auth::user();
        $isUser = Auth::check() && $user->role === 'user';

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

        $kategori = \App\Models\Kategori::all();
    @endphp

    <div id="app">
        <!-- Modern Glassmorphism Navbar -->
        <nav class="glass-nav sticky top-0 z-50 transition-all duration-300">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform">
                            <span class="text-2xl">📚</span>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Seilmu
                        </span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center gap-8">
                        @auth
                            @if ($isUser)
                                <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Home</a>
                                <a href="{{ route('user.about') }}" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">About</a>
                                <a href="{{ route('user.cart') }}" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Cart</a>
                                <a href="{{ route('user.transactions') }}" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">Orders</a>
                            @endif
                        @endauth

                        <!-- Chat with notifications -->
                        <div class="relative group">
                            <a href="{{ route('chat.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition-colors font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span>Chat</span>
                                @if ($userNotifCount > 0)
                                    <span class="notif-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                        {{ $userNotifCount }}
                                    </span>
                                @endif
                            </a>

                            @if ($isUser)
                                <div class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border overflow-hidden dropdown-enter">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold">
                                        Notifications
                                    </div>

                                    @if ($userNotifications->isEmpty())
                                        <div class="p-6 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p>No new notifications</p>
                                        </div>
                                    @else
                                        <ul class="max-h-80 overflow-y-auto">
                                            @foreach ($userNotifications as $notif)
                                                <li>
                                                    <a href="{{ route('chat.show', $notif->sender_id) }}" class="flex items-start p-4 hover:bg-gray-50 transition-colors">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg">
                                                                {{ strtoupper(substr($notif->sender->name ?? 'U', 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div class="ml-3 flex-1">
                                                            <div class="flex justify-between items-start">
                                                                <p class="font-semibold text-gray-900">{{ $notif->sender->name ?? 'User' }}</p>
                                                                <p class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                                                            </div>
                                                            <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($notif->message ?? 'New message', 100) }}</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="p-3 border-t text-center">
                                            <a href="{{ route('chat.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View all messages</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>



                       <div class="hidden lg:flex items-center gap-8">
        <form method="GET" action="{{ route('user.dashboard') }}" class="hidden lg:flex items-center gap-8">
    <!-- Search input desktop -->
    <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
            class="ajax-search search-input pl-10 pr-4 py-2 w-80 border border-gray-200 rounded-xl"
            autocomplete="off"
            data-suggest-url="{{ route('api.products.suggest') }}">
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" ...></svg>
        <div id="desktop-suggestions" class="suggestions-container hidden absolute mt-2 w-full"></div>
    </div>

    <!-- ✅ FILTER PANEL & APPLY (HARUS DI DALAM FORM) -->
    <div class="flex items-center gap-3">

        <!-- Dropdown button -->
        <div class="relative">
           <button type="button" id="priceSortBtn"
                                    class="flex items-center gap-2 border border-gray-200 rounded-xl px-4 py-2 bg-white hover:bg-gray-50 transition-all">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                                </svg>
                                <span class="text-gray-700 font-medium">Filter</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

            <!-- Dropdown panel -->
            <div id="priceSortPanel" class="hidden absolute right-0 mt-2 w-72 bg-white border rounded-xl shadow-xl p-4">

                <!-- Sort By -->
                <div class="mb-4">
                    <div class="text-sm font-semibold mb-2">Sort By</div>
                    <label><input type="radio" name="sort" value="latest" {{ request('sort')=='latest'?'checked':'' }}> Newest</label><br>
                    <label><input type="radio" name="sort" value="best" {{ request('sort')=='best'?'checked':'' }}> Best Seller</label><br>
                    <label><input type="radio" name="sort_harga" value="asc" {{ request('sort_harga')=='asc'?'checked':'' }}> Lowest</label><br>
                    <label><input type="radio" name="sort_harga" value="desc" {{ request('sort_harga')=='desc'?'checked':'' }}> Highest</label>
                </div>

                <!-- Price Range -->
                <div class="mb-4">
                    <div class="text-sm font-semibold mb-2">Price Range</div>
                    <div class="flex gap-2">
                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min" class="w-1/2 border rounded-lg px-3 py-2">
                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max" class="w-1/2 border rounded-lg px-3 py-2">
                    </div>
                </div>

                <!-- Rating + Category -->
                <div class="grid grid-cols-2 gap-3 mb-4">

                    <!-- Rating -->
                    <div>
                        <div class="text-sm font-semibold mb-1">Rating</div>
                        <select name="rating" class="w-full border rounded-lg px-2 py-2">
                            <option value="">All</option>
                            <option value="5" {{ request('rating')==5?'selected':'' }}>5+</option>
                            <option value="4" {{ request('rating')==4?'selected':'' }}>4+</option>
                            <option value="3" {{ request('rating')==3?'selected':'' }}>3+</option>
                            <option value="2" {{ request('rating')==2?'selected':'' }}>2+</option>
                            <option value="1" {{ request('rating')==1?'selected':'' }}>1+</option>
                        </select>
                    </div>

                    <!-- ✅ CATEGORY FIX -->
                    <div>
                        <div class="text-sm font-semibold mb-1">Category</div>
                        <select name="kategori" class="w-full border rounded-lg px-2 py-2">
                            <option value="">All</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori')==$k->id?'selected':'' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Reset -->
                <button type="button" id="priceReset" class="text-sm text-gray-600 hover:text-gray-900">Reset</button>
            </div>
        </div>

        <!-- ✅ APPLY BUTTON HARUS DI DALAM FORM -->

        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700">
            Apply
        </button>

    </div>
</form>


</div>


                    <!-- Right Side -->
                    <div class="hidden lg:flex items-center gap-4">
                        <!-- Dark Mode Toggle -->
                        <div class="theme-switch" onclick="toggleDarkMode()" title="Toggle theme">
                            <div class="theme-switch-slider">
                                <svg class="sun-icon text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                                </svg>
                                <svg class="moon-icon text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                                </svg>
                            </div>
                        </div>

                        @guest
                            <a href="{{ route('login') }}" class="px-6 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="btn-primary bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg transition-all transform hover:scale-105">
                                Sign Up
                            </a>
                        @else
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border overflow-hidden dropdown-enter">
                                    <div class="p-4 border-b">
                                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>

                                    <a href="{{ route('user.wishlist') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="font-medium text-gray-700">Wishlist</span>
                                    </a>

                                    <div class="border-t p-4">
                                        <div class="text-sm text-gray-600 mb-2 font-medium">Language</div>
                                        <div id="google_translate_element"></div>
                                    </div>

                                    <div class="border-t">
                                        <button onclick="confirmLogout(event)" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            <span class="font-medium">Logout</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="mobile-menu lg:hidden">
                    <div class="pt-4 pb-6 space-y-4">
                        @auth
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Home</a>
                            <a href="{{ route('user.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">About</a>
                            <a href="{{ route('user.cart') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Cart</a>
                            <a href="{{ route('user.transactions') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Orders</a>
                            <a href="{{ route('chat.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                Chat
                                @if ($userNotifCount > 0)
                                    <span class="inline-block bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">{{ $userNotifCount }}</span>
                                @endif
                            </a>
                        @endauth



                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                                    class="ajax-search w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500"
                                    autocomplete="off"
                                    data-suggest-url="{{ route('api.products.suggest') }}">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <div class="suggestions-container hidden mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50" id="mobile-suggestions"></div>
                            </div>

                            <!-- Mobile Price Filter -->
                            <details class="bg-gray-50 rounded-xl p-4">
                                <summary class="cursor-pointer font-medium text-gray-900 flex items-center justify-between">
                                    <span>Price & Filters</span>
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </summary>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <div class="text-sm text-gray-600 mb-2">Sort By:</div>
                                        <div class="flex gap-3">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="sort_harga" value="asc" class="form-radio text-blue-600" {{ request('sort_harga') == 'asc' ? 'checked' : '' }}>
                                                <span class="ml-2 text-gray-800">Lowest</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="sort_harga" value="desc" class="form-radio text-blue-600" {{ request('sort_harga') == 'desc' ? 'checked' : '' }}>
                                                <span class="ml-2 text-gray-800">Highest</span>

                                            </label>
                                            <label class="flex items-center cursor-pointer">
        <input type="radio" name="sort" value="best" class="form-radio text-blue-600"
               {{ request('sort') == 'best' ? 'checked' : '' }}>
        <span class="ml-2 text-gray-800">Best Seller</span>
    </label>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-sm text-gray-600 mb-2">Price Range:</div>
                                        <div class="flex gap-2">
                                            <input type="number" name="price_min" value="{{ request('price_min') }}" min="0" step="1000"
                                                   placeholder="Min" class="w-1/2 border border-gray-200 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:border-blue-500">
                                            <input type="number" name="price_max" value="{{ request('price_max') }}" min="0" step="1000"
                                                   placeholder="Max" class="w-1/2 border border-gray-200 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </details>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:shadow-lg transition-all">
                                Search
                            </button>
                        </form>

                        <!-- Dark Mode Toggle Mobile -->
                        <div class="flex items-center justify-between px-4 py-2 border-t pt-4">
                            <span class="text-gray-700 font-medium">Dark Mode</span>
                            <div class="theme-switch" onclick="toggleDarkMode()">
                                <div class="theme-switch-slider">
                                    <svg class="sun-icon text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                                    </svg>
                                    <svg class="moon-icon text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        @guest
                            <div class="space-y-2 pt-4 border-t">
                                <a href="{{ route('login') }}" class="block w-full text-center px-6 py-2 border border-blue-600 text-blue-600 rounded-xl font-medium hover:bg-blue-50 transition-all">Login</a>
                                <a href="{{ route('register') }}" class="block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg transition-all">Sign Up</a>
                            </div>
                        @else
                            <div class="pt-4 border-t space-y-2">
                                <a href="{{ route('user.wishlist') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                    ❤️ Wishlist
                                </a>

                                <div class="px-4 py-2">
                                    <div class="text-sm text-gray-600 mb-2 font-medium">Language</div>
                                    <div id="google_translate_element_mobile"></div>
                                </div>

                                <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="button" onclick="confirmLogout(event)" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="w-full min-h-screen">
            @yield('content')
        </main>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </div>

    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');

            if (document.getElementById('google_translate_element_mobile')) {
                new google.translate.TranslateElement({
                    pageLanguage: 'id',
                    includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element_mobile');
            }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        // Dark Mode
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });

        // Dropdown
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        }

        // Mobile Menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }

        // Logout Confirmation
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                background: document.body.classList.contains('dark-mode') ? '#1e293b' : '#fff',
                color: document.body.classList.contains('dark-mode') ? '#e2e8f0' : '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form')?.submit();
                    document.getElementById('logout-form-mobile')?.submit();
                }
            });
        }

        // Price sort panel toggle
        (function(){
            const btn = document.getElementById('priceSortBtn');
            const panel = document.getElementById('priceSortPanel');
            const reset = document.getElementById('priceReset');

            if (btn && panel) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    panel.classList.toggle('hidden');
                });

                if (reset) {
                    reset.addEventListener('click', () => {
                        panel.querySelectorAll('input').forEach(i => {
                            if (i.type === 'radio') i.checked = false;
                            else i.value = '';
                        });
                    });
                }

                document.addEventListener('click', (e) => {
                    if (!panel.contains(e.target) && !btn.contains(e.target)) {
                        panel.classList.add('hidden');
                    }
                });
            }
        })();

        // Autosuggest
        (function(){
            const debounce = (fn, delay=300) => {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            };

            function createSuggestionItem(item) {
                const el = document.createElement('div');
                el.className = 'suggestion-item flex items-center gap-3 p-3 cursor-pointer';
                el.innerHTML = `
                    <img src="${item.foto}" class="w-14 h-14 object-cover rounded-lg" alt="${escapeHtml(item.nama)}">
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 truncate">${escapeHtml(item.nama)}</div>
                        <div class="text-sm text-blue-600 font-medium">Rp ${Number(item.harga || 0).toLocaleString('id-ID')}</div>
                    </div>
                `;
                el.dataset.url = item.url;
                return el;
            }

            function escapeHtml(str){
                return String(str).replace(/[&<>"'`=\/]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;",'/':'&#47;','`':'&#96;','=':'&#61;'}[s]));
            }

            function attachAutosuggest(input, container) {
                const suggestUrl = input.dataset.suggestUrl;
                if (!suggestUrl) return;

                let activeIndex = -1;
                let items = [];

                const show = () => container.classList.remove('hidden');
                const hide = () => {
                    container.classList.add('hidden');
                    activeIndex = -1;
                    items = [];
                    container.innerHTML = '';
                };

                const setActive = (idx) => {
                    items.forEach((el, i) => {
                        if (i === idx) {
                            el.style.background = document.body.classList.contains('dark-mode') ? '#334155' : '#f3f4f6';
                        } else {
                            el.style.background = '';
                        }
                    });
                    activeIndex = idx;
                };

                const handleSelect = (idx) => {
                    const el = items[idx];
                    if (!el || !el.dataset.url) return;
                    window.location.href = el.dataset.url;
                };

                const fetchSuggestions = debounce(async (q) => {
                    if (!q || q.trim().length < 1) { hide(); return; }
                    try {
                        const res = await fetch(`${suggestUrl}?q=${encodeURIComponent(q)}`);
                        if (!res.ok) { hide(); return; }
                        const json = await res.json();
                        container.innerHTML = '';
                        if (!Array.isArray(json) || json.length === 0) { hide(); return; }
                        json.forEach(it => container.appendChild(createSuggestionItem(it)));
                        items = Array.from(container.children);
                        items.forEach((it, idx) => {
                            it.addEventListener('click', () => handleSelect(idx));
                            it.addEventListener('keydown', (e) => {
                                if (e.key === 'Enter') handleSelect(idx);
                            });
                        });
                        show();
                    } catch (err) {
                        hide();
                        console.error('Suggest error', err);
                    }
                }, 250);

                input.addEventListener('input', (e) => fetchSuggestions(e.target.value));

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (items.length === 0) return;
                        const next = (activeIndex + 1) % items.length;
                        setActive(next);
                        items[next].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (items.length === 0) return;
                        const prev = (activeIndex - 1 + items.length) % items.length;
                        setActive(prev);
                        items[prev].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'Enter') {
                        if (activeIndex >= 0) {
                            e.preventDefault();
                            handleSelect(activeIndex);
                        }
                    } else if (e.key === 'Escape') {
                        hide();
                    }
                });

                document.addEventListener('click', (ev) => {
                    if (!container.contains(ev.target) && ev.target !== input) hide();
                });

                input.addEventListener('blur', () => setTimeout(hide, 150));
            }

            document.addEventListener('DOMContentLoaded', () => {
                const desktopInput = document.querySelector('.ajax-search:not(.w-full)');
                const desktopContainer = document.getElementById('desktop-suggestions');
                if (desktopInput && desktopContainer) attachAutosuggest(desktopInput, desktopContainer);

                const mobileInput = document.querySelector('.ajax-search.w-full');
                const mobileContainer = document.getElementById('mobile-suggestions');
                if (mobileInput && mobileContainer) attachAutosuggest(mobileInput, mobileContainer);
            });
        })();
        document.addEventListener("DOMContentLoaded", () => {
    const bestRadio = document.querySelector("input[name='sort'][value='best']");
    const priceRadios = document.querySelectorAll("input[name='sort_harga']");

    if (bestRadio) {
        bestRadio.addEventListener("change", () => {
            if (bestRadio.checked) {
                priceRadios.forEach(r => r.checked = false);
            }
        });
    }

    priceRadios.forEach(r => {
        r.addEventListener("change", () => {
            if (r.checked) {
                bestRadio.checked = false;
            }
        });
    });
});
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#dropdownMenu') && !e.target.closest('button[onclick="toggleDropdown()"]')) {
                document.getElementById('dropdownMenu')?.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
