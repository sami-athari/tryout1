@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Verify Your Email Address
        </h2>

        <div class="space-y-4">
            @if (session('resent'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <p class="text-gray-700 text-center">
                Before proceeding, please check your email for a verification link.
            </p>

            <p class="text-gray-600 text-center text-sm">
                If you did not receive the email,
            </p>

            <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline font-medium">
                    click here to request another
                </button>
            </form>

            <div class="text-center pt-4 border-t">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
