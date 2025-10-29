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

        /* added: smooth height transition for panels */
        .transition-height {
            transition: max-height 300ms cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto mt-12 px-6">
    {{-- Judul --}}
    <h2 class="text-3xl font-extrabold text-center mb-8 text-gray-900">
        📋 Daftar Transaksi Pengguna
    </h2>

    @php
        // group transactions by user id (fallback to phone to avoid collisions for guests)
        $grouped = $transactions->groupBy(function($t){
            return $t->user->id ?? 'no_user_'.$t->telepon;
        });
    @endphp

    @if ($grouped->isEmpty())
        <div class="p-6 text-center rounded-xl bg-yellow-100 text-yellow-800 font-medium shadow-md">
            🚫 Belum ada transaksi masuk saat ini.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($grouped as $key => $group)
                @php
                    $first = $group->first();
                    $user = $first->user ?? null;
                    $displayName = $user->name ?? ($first->telepon ?? 'User tidak ditemukan');
                @endphp

                <div class="user-item glass p-4 shadow-sm">
                    <button
                        type="button"
                        class="user-toggle w-full flex items-center justify-between text-left gap-4"
                        aria-expanded="false"
                    >
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($displayName,0,1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $displayName }}</div>
                                <div class="text-xs text-gray-500">{{ $group->count() }} transaksi</div>
                            </div>
                        </div>

                        <svg class="chev w-5 h-5 text-gray-500 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="transactions-panel mt-4 transition-height max-h-0">
                        <div class="overflow-x-auto bg-white rounded-md shadow-inner">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-xs text-gray-600 uppercase">
                                    <tr class="text-center">
                                        <th class="py-3 px-4">#Invoice</th>
                                        <th class="py-3 px-4 text-left">Tanggal</th>
                                        <th class="py-3 px-4">Metode</th>
                                        <th class="py-3 px-4">Total</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($group as $trx)
                                        <tr class="text-center">
                                            <td class="py-3 px-4 font-semibold">#{{ $trx->id }}</td>
                                            <td class="py-3 px-4 text-left text-sm text-gray-700">
                                                {{ optional($trx->created_at)->format('d M Y') ?? '-' }}
                                            </td>
                                            <td class="py-3 px-4 capitalize">{{ $trx->metode_pembayaran }}</td>
                                            <td class="py-3 px-4 font-medium text-green-600">
                                                Rp {{ number_format($trx->total, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($trx->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($trx->status === 'dikirim') bg-blue-100 text-blue-800
                                                    @elseif($trx->status === 'selesai') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-700
                                                    @endif">
                                                    {{ ucfirst($trx->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if ($trx->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-3 py-1 rounded bg-green-600 text-white text-xs hover:bg-green-700">
                                                            ✅ Konfirmasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- small script to animate panels --}}
<script>
    (function(){
        function collapseAllIfNeeded() {
            // optional: keep closed on page load
        }
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.transactions-panel').forEach(function(p){
                p.style.maxHeight = '0px';
            });

            document.querySelectorAll('.user-toggle').forEach(function(btn){
                btn.addEventListener('click', function(){
                    var item = btn.closest('.user-item');
                    var panel = item.querySelector('.transactions-panel');
                    var expanded = btn.getAttribute('aria-expanded') === 'true';

                    if (!expanded) {
                        // expand
                        panel.style.maxHeight = panel.scrollHeight + 'px';
                        btn.setAttribute('aria-expanded', 'true');
                        btn.querySelector('.chev').classList.add('rotate-180');
                    } else {
                        // collapse
                        panel.style.maxHeight = '0px';
                        btn.setAttribute('aria-expanded', 'false');
                        btn.querySelector('.chev').classList.remove('rotate-180');
                    }
                });
            });

            // optional: adjust maxHeight on window resize for opened panels
            window.addEventListener('resize', function(){
                document.querySelectorAll('.user-item').forEach(function(item){
                    var btn = item.querySelector('.user-toggle');
                    var panel = item.querySelector('.transactions-panel');
                    if (btn.getAttribute('aria-expanded') === 'true') {
                        panel.style.maxHeight = panel.scrollHeight + 'px';
                    }
                });
            });
        });
    })();
</script>
@endsection
