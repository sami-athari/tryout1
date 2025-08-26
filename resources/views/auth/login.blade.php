@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">
            Masuk ke {{ config('app.name', 'Seilmu') }}
        </h2>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus placeholder="Email"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input id="password" type="password" name="password" required placeholder="Kata Sandi"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lupa password -->
            @if (Route::has('password.request'))
                <div class="text-right">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-700 hover:underline">Lupa Kata Sandi?</a>
                </div>
            @endif

            <!-- Tombol Login -->
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                Masuk
            </button>

            <!-- Link Register -->
            <p class="text-center text-gray-600 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-700 hover:underline font-medium">Daftar</a>
            </p>

            <!-- Kembali ke Beranda -->
            <p class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-700 text-sm">
                    ← Kembali ke Beranda
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
