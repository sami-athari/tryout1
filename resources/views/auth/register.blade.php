@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[85vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Register Account
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="Email"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Full Name"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password" name="password" required placeholder="Password"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li>Minimum 8 characters</li>
                <li>Include numbers & symbols</li>
            </ul>

            <div class="flex items-start space-x-2 text-sm">
                <input type="checkbox" id="privacy-check" required
                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="privacy-check" class="text-gray-600">
                    By registering, you agree to
                    <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Register
            </button>

            <p class="text-center text-gray-600 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
