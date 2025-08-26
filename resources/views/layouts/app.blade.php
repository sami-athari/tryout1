<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ReadHaus') }}</title>

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav>
            <div>
                <!-- Logo / App Name -->
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <!-- Navigation Links -->
                <div>
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}">Login</a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @else
                        <div>
                            <span>{{ Auth::user()->name }}</span>

                            <!-- Dropdown -->
                            <div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Main -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
