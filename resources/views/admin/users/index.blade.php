@extends('layouts.admin')

@section('content')
<div class="container mt-12 px-6">
    <h1 class="text-3xl font-bold mb-6 border-b-4 border-blue-500 pb-2 text-black">
        📋 Daftar Akun User
    </h1>

    <div class="mb-4">
        <span class="text-md text-black">Total akun terdaftar: 
            <strong class="text-black">{{ $total }}</strong>
        </span>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg bg-gray-900">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-800 text-black uppercase text-xs tracking-wider">
                <tr>
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">Nama</th>
                    <th class="py-3 px-5 text-left">Email</th>
                    <th class="py-3 px-5 text-left">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-black">
                @forelse ($users as $user)
                <tr class="hover:bg-blue transition duration-200">
                    <td class="py-3 px-5">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td class="py-3 px-5">{{ $user->name }}</td>
                    <td class="py-3 px-5">{{ $user->email }}</td>
                    <td class="py-3 px-5">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-red-400">Belum ada user terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links('pagination::tailwind') }}
    </div>

    <div class="mt-10">
        <a href="{{ route('admin.dashboard') }}" class="btn fw-semibold" style="background-color: #facc15; color: black;">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
