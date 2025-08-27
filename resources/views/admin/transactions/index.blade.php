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
        .badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
        .badge-pending {
            @apply bg-yellow-400 text-black;
        }
        .badge-dikirim {
            @apply bg-blue-400 text-white;
        }
        .badge-selesai {
            @apply bg-green-500 text-white;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto mt-12 px-6">
    {{-- Judul --}}
    <h2 class="text-3xl font-extrabold text-center mb-8 text-gray-900">
        📋 Daftar Transaksi Pengguna
    </h2>

    @if ($transactions->isEmpty())
        <div class="p-6 text-center rounded-xl bg-yellow-100 text-yellow-800 font-medium shadow-md">
            🚫 Belum ada transaksi masuk saat ini.
        </div>
    @else
        <div class="overflow-x-auto shadow-2xl glass">
            <table class="min-w-full text-sm">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white uppercase text-xs tracking-wider">
                    <tr class="text-center">
                        <th class="py-4 px-6">#Invoice</th>
                        <th class="py-4 px-6 text-left">Pengguna</th>
                        <th class="py-4 px-6">Telepon</th>
                        <th class="py-4 px-6">Alamat</th>
                        <th class="py-4 px-6 text-left">Produk</th>
                        <th class="py-4 px-6">Metode Bayar</th>
                        <th class="py-4 px-6">Total</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($transactions as $trx)
                        @php $total = 0; @endphp
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="py-4 px-6 font-bold text-center text-gray-700">
                                #{{ $trx->id }}
                            </td>
                            <td class="py-4 px-6 text-gray-900">{{ $trx->user->name }}</td>
                            <td class="py-4 px-6 text-center text-gray-700">{{ $trx->telepon }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ $trx->alamat }}</td>
                            <td class="py-4 px-6">
                                <ul class="space-y-2">
                                    @foreach ($trx->items as $item)
                                        @php
                                            $subtotal = $item->harga * $item->jumlah;
                                            $total += $subtotal;
                                        @endphp
                                        <li class="bg-gray-100 rounded-md px-3 py-2">
                                            🛒 <span class="font-semibold">{{ $item->produk->nama }}</span>
                                            x {{ $item->jumlah }}
                                            <div class="text-sm text-gray-500">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-4 px-6 text-center capitalize text-gray-800">
                                {{ $trx->metode_pembayaran }}
                            </td>
                            <td class="py-4 px-6 font-bold text-green-600 text-center">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="badge
                                    @if($trx->status === 'pending') badge-pending
                                    @elseif($trx->status === 'dikirim') badge-dikirim
                                    @elseif($trx->status === 'selesai') badge-selesai
                                    @endif">
                                    {{ strtoupper($trx->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($trx->status === 'pending')
                                    <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm shadow-md transition">
                                            ✅ Konfirmasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
