@extends('layouts.app')

@section('content')
    <h2>Masuk Akun ReadHaus</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
        @error('email')
            <p><strong>{{ $message }}</strong></p>
        @enderror

        <input id="password" type="password" name="password" required placeholder="Kata Sandi">
        @error('password')
            <p><strong>{{ $message }}</strong></p>
        @enderror

        @if (Route::has('password.request'))
            <p><a href="{{ route('password.request') }}">Lupa Kata Sandi?</a></p>
        @endif

        <button type="submit">Masuk</button>

        <p><a href="{{ url('/') }}">← Kembali ke Beranda</a></p>

        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </form>
@endsection
