@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Login to {{ config('app.name', 'Seilmu') }}
        </h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus placeholder="Email"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input id="password" type="password" name="password" required placeholder="Password"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if (Route::has('password.request'))
                <div class="text-right">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>
            @endif

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Login
            </button>

            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Register</a>
            </p>

            <p class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
