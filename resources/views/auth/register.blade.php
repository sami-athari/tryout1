@extends('layouts.app')

@section('content')
    <h2>Daftar Akun Readhaus</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
        @error('email')
            <p><strong>{{ $message }}</strong></p>
        @enderror

        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap">
        @error('name')
            <p><strong>{{ $message }}</strong></p>
        @enderror

        <input type="password" name="password" required placeholder="Kata Sandi">
        @error('password')
            <p><strong>{{ $message }}</strong></p>
        @enderror

        <input type="password" name="password_confirmation" required placeholder="Konfirmasi Kata Sandi">

        <ul>
            <li>Minimum 8 karakter.</li>
            <li>Sertakan angka & simbol.</li>
        </ul>

        <div>
            <input type="checkbox" required id="privacy-check">
            <label for="privacy-check">
                Dengan mendaftar, kamu menyetujui
                <a href="#">Kebijakan Privasi Readhaus.com</a>
            </label>
        </div>

        <button type="submit">Daftar</button>

        <p>
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </p>
    </form>
@endsection
