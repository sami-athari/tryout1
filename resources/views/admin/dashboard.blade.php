@extends('layouts.admin')

@section('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
        }
    </style>
@endsection

@section('content')
<div class="min-h-screen py-12 px-6">

    <div class="max-w-7xl mx-auto space-y-12">

        {{-- Welcome --}}
        <div class="glass rounded-3xl shadow-2xl p-10 flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
            <div>
                <h1 class="text-4xl font-extrabold text-blue-900">👋 Halo, {{ Auth::user()->name }}</h1>
                <p class="text-blue-700 mt-2">Selamat datang kembali di <span class="font-semibold">Dashboard Admin ReadHaus</span></p>
                <p class="text-sm text-gray-600 mt-1">Hari ini: {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="mt-6 md:mt-0">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="h-28 w-28 rounded-full border-4 border-white shadow-lg" />
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="glass rounded-2xl p-6 shadow-md text-center hover:scale-105 transition">
                <h2 class="text-lg font-semibold text-gray-700">📚 Produk</h2>
                <p class="text-4xl font-extrabold text-blue-700 mt-2">{{ \App\Models\Produk::count() }}</p>
            </div>

            <div class="glass rounded-2xl p-6 shadow-md text-center hover:scale-105 transition">
                <h2 class="text-lg font-semibold text-gray-700">🗂 Kategori</h2>
                <p class="text-4xl font-extrabold text-blue-700 mt-2">{{ \App\Models\Kategori::count() }}</p>
            </div>

            <div class="glass rounded-2xl p-6 shadow-md text-center hover:scale-105 transition">
                <h2 class="text-lg font-semibold text-gray-700">👥 User</h2>
                <p class="text-4xl font-extrabold text-blue-700 mt-2">{{ \App\Models\User::where('role','user')->count() }}</p>
            </div>

            <div class="glass rounded-2xl p-6 shadow-md text-center hover:scale-105 transition">
                <h2 class="text-lg font-semibold text-gray-700">💰 Transaksi</h2>
                <p class="text-4xl font-extrabold text-blue-700 mt-2">{{ \App\Models\Transaction::count() }}</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h2 class="text-2xl font-bold text-blue-900 mb-6">🚀 Aksi Cepat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <a href="{{ route('admin.produk.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-2xl shadow-xl text-white font-semibold text-xl flex flex-col items-center hover:from-blue-600 hover:to-blue-700 transition transform hover:-translate-y-1">
                    📖 Kelola Produk
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 rounded-2xl shadow-xl text-white font-semibold text-xl flex flex-col items-center hover:from-indigo-600 hover:to-indigo-700 transition transform hover:-translate-y-1">
                    🗂 Kelola Kategori
                </a>
                <a href="{{ route('chat.index') }}" class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-2xl shadow-xl text-white font-semibold text-xl flex flex-col items-center hover:from-green-600 hover:to-green-700 transition transform hover:-translate-y-1">
                    💬 Lihat Pesan
                </a>
            </div>
        </div>

        {{-- Notifikasi / Info --}}
        <div class="glass rounded-2xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">📢 Informasi</h2>
            <ul class="space-y-3 text-gray-700">
                <li>✅ Sistem berjalan normal tanpa gangguan.</li>
                <li>🔔 Ada <span class="font-semibold">{{ \App\Models\User::where('role','user')->count() }}</span> user aktif minggu ini.</li>
                <li>📦 Stok produk perlu dicek secara berkala.</li>
            </ul>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Selamat Datang 👋',
            text: 'Halo {{ Auth::user()->name }}, senang melihatmu kembali!',
            icon: 'success',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Lanjutkan'
        });
    </script>
@endsection
