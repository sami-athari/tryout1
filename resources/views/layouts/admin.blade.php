<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            padding-top: 70px;
            background: linear-gradient(to bottom right, #ffffff);

            color: #e0f2f1;
            min-height: 100vh;
        }

        .navbar {
            background-color: #164ac5 !important;
        }

        .navbar .nav-link,
        .navbar .navbar-brand,
        .navbar .dropdown-toggle {
            color: #e0f2f1 !important;
        }

        .navbar-toggler-icon-custom {
            cursor: pointer;
            width: 25px;
            height: 20px;
            display: inline-block;
            position: relative;
        }

        .navbar-toggler-icon-custom span {
            background: #e0f2f1;
            position: absolute;
            height: 3px;
            width: 100%;
            left: 0;
            transition: 0.3s;
            border-radius: 2px;
        }

        .navbar-toggler-icon-custom span:nth-child(1) { top: 0; }
        .navbar-toggler-icon-custom span:nth-child(2) { top: 8px; }
        .navbar-toggler-icon-custom span:nth-child(3) { top: 16px; }

        .dropdown-menu {
            background-color:  #1e68fd;
            border: none;
        }

        .dropdown-menu .dropdown-item {
            color: #090909;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color:  #1874fd;
        }

        .nav-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .nav-center a {
            margin: 0 15px;
        }

        .notif-bubble {
            position: absolute;
            top: 0px;
            right: -6px;
            background-color: red;
            color: white;
            font-size: 10px;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
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


<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold" href="{{ url('/admin/dashboard') }}">
                {{ Auth::user()->name }} (ReadHaus)
            </a>

            <div class="nav-center d-none d-md-flex">
                 <a class="nav-link" href="{{ route('admin.dashboard') }}">beranda</a>

                <a class="nav-link" href="{{ route('admin.produk.index') }}">Produk</a>
                <a class="nav-link" href="{{ route('admin.kategori.index') }}">Kategori</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Akun</a>
                 <a class="nav-link" href="{{ route('admin.transactions.index') }}">histroy</a>

               <div class="position-relative">
    <a class="nav-link" href="{{ route('chat.index') }}">
         Pesan
    </a>
    @if ($adminNotif)
        <span class="notif-bubble">•</span>
    @endif
</div>

            </div>

            <div class="dropdown">
                <a class="nav-link dropdown-toggle navbar-toggler-icon-custom" href="#" id="dropdownMenuButton" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="#" onclick="confirmLogout(event)">Logout</a>
                    </li>
                </ul>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>

    <div class="px-4 py-5">
        @yield('content')
    </div>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Keluar dari akun?',
            text: "Kamu akan keluar dari akun admin!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#004d40',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
</body>
</html>
