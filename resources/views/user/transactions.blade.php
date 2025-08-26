@extends('layouts.user')

@section('content')
<div>
    <h2>Riwayat Transaksi</h2>

    @forelse($transaksi as $trx)
        <div>
            <div>
                <p>Invoice: #{{ $trx->id }}</p>
                <p>
                    Status: {{ ucfirst($trx->status) }}
                </p>
            </div>

            <div>
                {{-- Tampilkan struk hanya jika status bukan pending --}}
                @if ($trx->status !== 'pending')
                    <a href="{{ route('user.struk', $trx->id) }}">
                        Lihat Struk
                    </a>
                @endif

                {{-- Tampilkan tombol "Terima" hanya jika status dikirim --}}
                @if ($trx->status === 'dikirim')
                    <form method="POST" action="{{ route('user.transactions.selesai', $trx->id) }}">
                        @csrf
                        <button type="submit">Terima</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>Belum ada transaksi yang tercatat.</p>
    @endforelse
</div>
@endsection
