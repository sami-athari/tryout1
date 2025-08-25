@extends('layouts.admin')

@section('content')
<style>
    .table-dark-blue {
        background-color: #1f2d3d;
        color: #fff;
    }
    .table-dark-blue th {
        background-color: #22354a;
        color: #ffc107;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #000;
    }
    .badge-dikirim {
        background-color: #0dcaf0;
    }
    .badge-selesai {
        background-color: #28a745;
    }
</style>

<div class="container mt-5">
    <h2 class="text-black text-center mb-4 fw-bold">📋 Daftar Transaksi Pengguna</h2>

    @if ($transactions->isEmpty())
        <div class="alert alert-info text-center">
            🚫 Belum ada transaksi masuk saat ini.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-dark-blue table-bordered text-black">
                <thead>
                    <tr class="text-center align-middle">
                        <th>#Invoice</th>
                        <th>Pengguna</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Produk</th>
                        <th>Metode Bayar</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $trx)
                        <tr>
                            <td class="text-center fw-bold">#{{ $trx->id }}</td>
                            <td>{{ $trx->user->name }}</td>
                            <td>{{ $trx->telepon }}</td>
                            <td>{{ $trx->alamat }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @php $total = 0; @endphp
                                    @foreach ($trx->items as $item)
                                        @php
                                            $subtotal = $item->harga * $item->jumlah;
                                            $total += $subtotal;
                                        @endphp
                                        <li>
                                            🛒 {{ $item->produk->nama }} x {{ $item->jumlah }}<br>
                                            <small>Rp {{ number_format($subtotal, 0, ',', '.') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-capitalize">{{ $trx->metode_pembayaran }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge-status 
                                    @if($trx->status === 'pending') badge-pending
                                    @elseif($trx->status === 'dikirim') badge-dikirim
                                    @elseif($trx->status === 'selesai') badge-selesai
                                    @endif
                                ">
                                    {{ strtoupper($trx->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($trx->status === 'pending')
                                    <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success w-100">✅ Konfirmasi</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
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
