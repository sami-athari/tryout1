@extends('layouts.app')

@section('content')
<style>
    .register-wrapper {
        display: flex;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, #e3f2fd,);
    }

    .register-card {
        background: white;
        display: flex;
        max-width: 960px;
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .register-image {
        background: #fff;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .register-image img {
        width: 100%;
        max-width: 360px;
        height: auto;
    }

    .register-form {
        flex: 1;
        padding: 2.5rem;
        background-color: #f5faff;
    }

    .register-form h2 {
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #0D47A1;
    }

    .form-control {
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #90caf9;
        padding: 10px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
    }

    .form-check-label,
    label {
        color: #0D47A1;
    }

    .btn-register {
        background-color: #1565C0;
        color: white;
        width: 100%;
        border-radius: 10px;
        padding: 0.6rem;
        font-weight: 500;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-register:hover {
        background-color: #0D47A1;
    }

    .small-note {
        font-size: 0.9rem;
        color: #555;
        margin-top: 10px;
    }

    .login-link {
        color: #1565C0;
        font-weight: 500;
    }

    .login-link:hover {
        text-decoration: underline;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <!-- Left: Image -->
        <div class="register-image">
            <img src="{{ asset('images/bukbuk.jpg') }}" alt="Register Illustration">
        </div>

        <!-- Right: Form -->
        <div class="register-form">
            <h2>Daftar Akun Readhaus</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                @enderror

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                @enderror

                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Kata Sandi" required>
                @error('password')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                @enderror

                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Konfirmasi Kata Sandi" required>

                <div class="small-note">
                    <ul class="mb-2 ps-3">
                        <li>Minimum 8 karakter.</li>
                        <li>Sertakan angka & simbol.</li>
                    </ul>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" required id="privacy-check">
                    <label class="form-check-label" for="privacy-check">
                        Dengan mendaftar, kamu menyetujui <a href="#" class="login-link">Kebijakan Privasi Readhaus.com</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-register">Daftar</button>

                <div class="small-note text-center mt-3">
                    Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
