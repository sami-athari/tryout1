@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .login-wrapper {
        display: flex;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, #e3f2fd, #e1f5fe); /* gradasi biru muda */
        padding: 20px;
    }

    .login-card {
        background: #ffffff;
        display: flex;
        flex-direction: row;
        max-width: 980px;
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login-image {
        flex: 1;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
        border-right: 1px solid #e0e0e0;
    }

    .login-image img {
        width: 100%;
        max-width: 360px;
        height: auto;
    }

    .login-form {
        flex: 1;
        padding: 40px;
        background-color: #f4f8fb;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-form h2 {
        font-weight: 600;
        font-size: 24px;
        margin-bottom: 30px;
        color: #0d47a1; /* biru gelap */
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        font-size: 14px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #1565c0; /* biru sedang */
        box-shadow: none;
    }

    .btn-login {
        background-color: #0d47a1; /* biru gelap */
        color: white;
        width: 100%;
        border-radius: 10px;
        padding: 12px;
        font-weight: 500;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-login:hover {
        background-color: #0b3c91;
    }

    .btn-secondary {
        background-color: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #bbdefb;
        padding: 12px;
        font-weight: 500;
        border-radius: 10px;
        width: 100%;
        margin-top: 16px;
        transition: background-color 0.3s;
        text-align: center;
        display: inline-block;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: #bbdefb;
        color: #0b3c91;
    }

    .form-bottom {
        text-align: center;
        font-size: 0.95rem;
        margin-top: 24px;
    }

    .form-bottom a {
        color: #0d47a1;
        font-weight: 500;
        text-decoration: none;
    }

    .form-bottom a:hover {
        text-decoration: underline;
    }

    .forgot-link {
        text-align: right;
        font-size: 0.9rem;
        margin-top: -5px;
        margin-bottom: 18px;
    }

    .forgot-link a {
        color: #0d47a1;
        text-decoration: none;
    }

    .forgot-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
        }

        .login-image {
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
        }

        .login-form {
            padding: 30px 20px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <!-- Left Side: Image -->
        <div class="login-image">
            <img src="{{ asset('images/bukbuk.jpg') }}" alt="Login Illustration">
        </div>

        <!-- Right Side: Form -->
        <div class="login-form">
            <h2>Masuk Akun ReadHaus</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus
                    placeholder="Email">
                @error('email')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                @enderror

                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required
                    placeholder="Kata Sandi">
                @error('password')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                @enderror

                <div class="forgot-link">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Masuk</button>

                <a href="{{ url('/') }}" class="btn-secondary">← Kembali ke Beranda</a>

                <div class="form-bottom">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
