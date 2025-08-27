@extends('layouts.admin')

@section('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd, #7dd3fc);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto mt-12 px-6">
    {{-- Judul --}}
    <h1 class="text-4xl font-extrabold mb-8 text-center text-gray-900 tracking-wide">
        📋 Daftar Akun User
    </h1>

    {{-- Total Akun --}}
    <div class="mb-6 text-center">
        <span class="text-lg text-gray-800">
            Total akun terdaftar:
            <strong class="text-blue-700">{{ $total }}</strong>
        </span>
    </div>

    {{-- Tabel User --}}
    <div class="overflow-hidden shadow-2xl glass">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white uppercase text-xs tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">#</th>
                    <th class="py-4 px-6 text-left">Nama</th>
                    <th class="py-4 px-6 text-left">Email</th>
                    <th class="py-4 px-6 text-left">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($users as $user)
                <tr class="hover:bg-blue-50 transition duration-200">
                    <td class="py-4 px-6 font-semibold text-gray-700">
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>
                    <td class="py-4 px-6 text-gray-900">{{ $user->name }}</td>
                    <td class="py-4 px-6 text-gray-700">{{ $user->email }}</td>
                    <td class="py-4 px-6 text-gray-600">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-red-500 font-medium">
                        Belum ada user terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $users->links('pagination::tailwind') }}
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-10 text-center">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-6 py-3 rounded-xl font-semibold shadow-md bg-yellow-400 text-gray-900 hover:bg-yellow-500 transition">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
