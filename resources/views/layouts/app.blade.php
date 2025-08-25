<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ReadHaus') }}</title>

    <!-- Font -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #164ac5;
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="text-gray-800">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-600 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo / App Name -->
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-white hover:text-yellow-300 transition duration-200">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <!-- Navigation Links -->
                    <div class="flex space-x-4 items-center">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}"
                                   class="px-4 py-2 bg-white text-blue-900 font-semibold rounded hover:bg-blue-100 transition duration-150">
                                    Login
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-2 bg-white text-blue-900 font-semibold rounded hover:bg-blue-100 transition duration-150">
                                    Register
                                </a>
                            @endif
                        @else
                            <div class="relative group">
                                <button type="button"
                                    class="inline-flex items-center text-white font-medium hover:text-yellow-300 transition duration-150">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5.25 7L10 11.75 14.75 7z" />
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-blue-700 text-white hidden group-hover:block z-50">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left px-4 py-2 hover:bg-blue-600 transition">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main -->
        <main class="py-10 px-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
