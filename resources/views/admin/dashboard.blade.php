@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe, #bae6fd);
            min-height: 100vh;
        }

        .card {
            background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa);
            color: #f8fafc;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            background: linear-gradient(135deg, #2563eb, #60a5fa, #bfdbfe);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 30px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="min-h-screen font-sans">

    <div class="p-10 max-w-5xl mx-auto mt-16 rounded-2xl shadow-2xl bg-white bg-opacity-60 backdrop-blur-md border border-blue-200">
        <h1 class="text-5xl font-extrabold mb-3 tracking-tight text-blue-900 drop-shadow-sm">📖 Selamat Datang, Admin</h1>
        <p class="text-blue-800 mb-10 text-lg">Kelola produk dan kategori <span class="font-semibold">Bookstore</span>Ini ATmin ReadHaus Untuk Mengatur Semuanya.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

            {{-- Produk --}}
            <a href="{{ route('admin.produk.index') }}"
               class="block border-l-4 border-blue-300 p-6 rounded-xl transition shadow-lg hover:shadow-2xl card group">
                <h2 class="text-2xl font-semibold text-blue-50 flex items-center gap-2">
                    📚 <span class="group-hover:underline">Kelola Produk</span>
                </h2>
                <p class="text-blue-100 mt-2">Tambah, ubah, dan hapus produk buku dengan mudah.</p>
            </a>

            {{-- Kategori --}}
            <a href="{{ route('admin.kategori.index') }}"
               class="block border-l-4 border-blue-300 p-6 rounded-xl transition shadow-lg hover:shadow-2xl card group">
                <h2 class="text-2xl font-semibold text-blue-50 flex items-center gap-2">
                    🗂 <span class="group-hover:underline">Kelola Kategori</span>
                </h2>
                <p class="text-blue-100 mt-2">Atur kategori buku agar lebih rapi dan terorganisir.</p>
            </a>

        </div>
    </div>

    {{-- SweetAlert --}}
    <script>
        Swal.fire({
            title: 'Selamat Datang!',
            text: 'Anda berhasil masuk sebagai Admin Bookstore.',
            icon: 'success',
            confirmButtonColor: '#3b82f6',
            confirmButtonText: 'Lanjutkan'
        });
    </script>
</body>
</html>
@endsection
