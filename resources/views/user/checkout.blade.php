@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <h1 class="text-3xl font-bold text-white mb-6">💳 Checkout</h1>

    @if ($items->count() > 0)
        {{-- Ringkasan Pesanan --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 text-black">
            <h2 class="text-xl font-semibold mb-4">📦 Ringkasan Pesanan</h2>

            <table class="w-full table-auto text-sm border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Produk</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($items as $item)
                        @php
                            $subtotal = $item->jumlah * $item->produk->harga;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $item->produk->nama }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $item->jumlah }}</td>
                            <td class="py-2 px-4 border-b text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-right text-lg font-bold text-green-800">
                Total Harga: Rp {{ number_format($total, 0, ',', '.') }}
            </div>
        </div>

        {{-- Form Checkout --}}
        <form method="POST" action="{{ route('user.checkout.process') }}" class="bg-white p-6 rounded-xl shadow space-y-4 text-black">
            @csrf

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium mb-1">📍 Alamat Pengiriman</label>
                <textarea name="alamat" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-green-500">{{ old('alamat') }}</textarea>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-sm font-medium mb-1">📞 Nomor Telepon</label>
                <input type="text" name="telepon" required
                       pattern="[0-9]{10,13}" minlength="10" maxlength="13"
                       value="{{ old('telepon') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-green-500">
            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <label class="block text-sm font-medium mb-1">💰 Metode Pembayaran</label>
                <select name="metode_pembayaran" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-green-500">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="OVO">OVO</option>
                    <option value="Dana">Dana</option>
                    <option value="Gopay">Gopay</option>
                </select>
            </div>

            {{-- Info Pembayaran --}}
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-medium">Silakan transfer ke nomor berikut:</p>
                <p class="text-lg font-bold text-green-700 mt-1">0857 7440 7831</p>
                <p class="text-sm text-gray-600">Atas nama: Admin Toko Buku</p>
            </div>

            {{-- Total harga dikirim ke backend --}}
            <input type="hidden" name="total_harga" value="{{ $total }}">

            <button type="submit"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-full transition">
                🛒 Konfirmasi dan Proses Pesanan
            </button>
        </form>
    @else
        <div class="bg-red-100 text-red-700 p-4 rounded shadow text-center">
            Keranjang kosong. Silakan tambahkan produk terlebih dahulu.
        </div>
    @endif
</div>
@endsection
