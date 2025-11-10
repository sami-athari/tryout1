@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Confirm Password
        </h2>

        <p class="text-gray-700 text-center mb-6">
            Please confirm your password before continuing.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-3">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Confirm Password
                </button>

                @if (Route::has('password.request'))
                    <a class="block text-center text-blue-600 hover:underline text-sm" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                @endif
            </div>

            <div class="text-center pt-4 border-t">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
