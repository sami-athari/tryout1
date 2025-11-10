@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Reset Password
        </h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password-confirm" type="password" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Reset Password
            </button>

            <div class="text-center pt-4 border-t">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
