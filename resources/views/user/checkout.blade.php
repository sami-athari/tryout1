@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6 text-center dark:text-white">📝 Checkout</h1>

    @if ($items->count() > 0)
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Ringkasan Pesanan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border dark:border-gray-700 rounded-lg">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Produk</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        @php $total = 0; @endphp
                        @foreach ($items as $item)
                            @php
                                $subtotal = $item->jumlah * $item->produk->harga;
                                $total += $subtotal;
                            @endphp
                            <tr class="dark:text-gray-300">
                                <td class="px-4 py-3 font-medium">{{ $item->produk->nama }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400 font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <td colspan="2" class="px-4 py-3 text-right font-bold dark:text-white">Total Harga</td>
                            <td class="px-4 py-3 text-right font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" action="{{ route('user.checkout.process') }}" class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-2 dark:text-white">Alamat Pengiriman</label>
                <textarea name="alamat" rows="3" required
                    class="w-full border dark:border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 dark:text-white">Nomor Telepon</label>
                <input type="text" name="telepon" required pattern="[0-9]{10,13}" minlength="10" maxlength="13"
                    value="{{ old('telepon') }}"
                    class="w-full border dark:border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 dark:text-white">Metode Pembayaran</label>
                <select name="metode_pembayaran" required
                    class="w-full border dark:border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="OVO">OVO</option>
                    <option value="Dana">Dana</option>
                    <option value="Gopay">Gopay</option>
                </select>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border dark:border-gray-600">
                <p class="text-gray-700 dark:text-gray-300 mb-1">💳 Silakan transfer ke nomor berikut:</p>
                <p class="font-semibold text-blue-600 dark:text-blue-400">+62-851-5959-2448</p>
                <p class="text-gray-600 dark:text-gray-400">Atas nama: <span class="font-medium">Admin Toko Buku</span></p>
            </div>

            <input type="hidden" name="total_harga" value="{{ $total }}">

            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                ✅ Konfirmasi dan Proses Pesanan
            </button>
        </form>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 dark:text-gray-400 text-lg">Keranjang kosong. Silakan tambahkan produk terlebih dahulu 🛍</p>
            <a href="{{ route('user.dashboard') }}"
               class="mt-4 inline-block px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
