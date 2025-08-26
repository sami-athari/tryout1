@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8 text-center">📝 Checkout</h1>

    @if ($items->count() > 0)
        {{-- Ringkasan Pesanan --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-blue-900 mb-4">Ringkasan Pesanan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Produk</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $total = 0; @endphp
                        @foreach ($items as $item)
                            @php
                                $subtotal = $item->jumlah * $item->produk->harga;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $item->produk->nama }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-blue-800 font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-100">
                            <td colspan="2" class="px-4 py-3 text-right font-bold">Total Harga</td>
                            <td class="px-4 py-3 text-right font-bold text-blue-900">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Form Checkout --}}
        <form method="POST" action="{{ route('user.checkout.process') }}" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                <textarea name="alamat" rows="3" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('alamat') }}</textarea>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="telepon" required pattern="[0-9]{10,13}" minlength="10" maxlength="13"
                    value="{{ old('telepon') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select name="metode_pembayaran" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="OVO">OVO</option>
                    <option value="Dana">Dana</option>
                    <option value="Gopay">Gopay</option>
                </select>
            </div>

            {{-- Info Pembayaran --}}
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="text-gray-700 mb-1">💳 Silakan transfer ke nomor berikut:</p>
                <p class="font-semibold text-blue-900">+62-851-5959-2448</p>
                <p class="text-gray-600">Atas nama: <span class="font-medium">Admin Toko Buku</span></p>
            </div>

            {{-- Total harga dikirim ke backend --}}
            <input type="hidden" name="total_harga" value="{{ $total }}">

            <button type="submit"
                class="w-full py-3 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition">
                ✅ Konfirmasi dan Proses Pesanan
            </button>
        </form>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">Keranjang kosong. Silakan tambahkan produk terlebih dahulu 🛍</p>
            <a href="{{ route('user.dashboard') }}"
               class="mt-4 inline-block px-5 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
