@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h2>

    @forelse($transaksi as $trx)
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold text-gray-700">Invoice: #{{ $trx->id }}</p>
                    <p class="mt-1">
                        <span class="font-medium">Status:</span>
                        @if($trx->status === 'pending')
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        @elseif($trx->status === 'dikirim')
                            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                Dikirim
                            </span>
                        @elseif($trx->status === 'selesai')
                            <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                                Selesai
                            </span>
                        @elseif($trx->status === 'dibatalkan')
                            <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">
                                Dibatalkan
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm bg-gray-200 text-gray-700">
                                {{ ucfirst($trx->status) }}
                            </span>
                        @endif
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Tampilkan struk hanya jika status bukan pending --}}
                    @if ($trx->status !== 'pending')
                        <a href="{{ route('user.struk', $trx->id) }}"
                           class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                            Lihat Struk
                        </a>
                    @endif

                    {{-- Tampilkan tombol "Terima" hanya jika status dikirim --}}
                    @if ($trx->status === 'dikirim')
                        <form method="POST" action="{{ route('user.transactions.selesai', $trx->id) }}">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-500 transition">
                                Terima
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center">Belum ada transaksi yang tercatat.</p>
    @endforelse
</div>
@endsection
