@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">
    <a href="{{ route('user.dashboard') }}"
       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline mb-6">
        ← Kembali ke Dashboard
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6">
            <img id="mainImage"
                 src="{{ asset('storage/' . $produk->foto) }}"
                 alt="{{ $produk->nama }}"
                 class="w-full h-96 object-contain">
        </div>

        <div>
            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold mb-3 dark:text-white">{{ $produk->nama }}</h1>

                @if($produk->kategori)
                    <span class="inline-block px-3 py-1 bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded text-sm mb-4">
                        {{ $produk->kategori->nama }}
                    </span>
                @endif

                @php
                    $average = $produk->reviews->avg('rating') ?? 0;
                    $totalReviews = $produk->reviews->count();
                    $sold = (int) ($produk->transaction_count ?? 0);
                    if ($sold >= 1000) {
                        $soldLabel = number_format($sold / 1000, 1) . 'k+';
                    } else {
                        $soldLabel = (string) $sold;
                    }
                @endphp

                <div class="flex items-center gap-2 mb-4">
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($average) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">★</span>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ number_format($average, 1) }}/5 ({{ $totalReviews }} ulasan)
                    </span>
                </div>

                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">{{ $soldLabel }} terjual</p>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2 dark:text-white">Stok</h3>
                    <div class="text-xl font-bold {{ $produk->stok > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        @if($produk->stok > 0)
                            {{ $produk->stok }} tersedia
                        @else
                            Habis
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2 dark:text-white">Deskripsi Produk</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $produk->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
                    </p>
                </div>

                @if($produk->stok > 0)
                    <form action="{{ route('user.cart.add', $produk->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-3 mb-4">
                            <label class="font-medium dark:text-white">Jumlah:</label>
                            <div class="flex items-center border dark:border-gray-600 rounded-lg overflow-hidden">
                                <button type="button" onclick="decrementQty()" class="px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">−</button>
                                <input type="number" name="jumlah" id="quantity" value="1" min="1" max="{{ $produk->stok }}"
                                       class="w-16 text-center border-0 dark:bg-gray-800 dark:text-white">
                                <button type="button" onclick="incrementQty()" class="px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">+</button>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Maks: {{ $produk->stok }}</span>
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                            + Masukkan ke Keranjang
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6">
                <h3 class="font-bold mb-4 dark:text-white">Ulasan Pembeli</h3>

                @php $reviews = $produk->reviews ?? collect(); @endphp

                @if($reviews->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada ulasan untuk produk ini.</p>
                @else
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($reviews->take(10) as $review)
                            @php
                                $rating = (int) ($review->rating ?? 0);
                                $comment = $review->komentar ?? $review->comment ?? '';
                                $reviewer = $review->user->name ?? 'Pengguna';
                                $time = optional($review->created_at)->diffForHumans() ?? '';
                            @endphp

                            <div class="border-b dark:border-gray-700 pb-4 last:border-0">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($reviewer, 0, 1)) }}
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-semibold dark:text-white">{{ $reviewer }}</span>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} text-sm">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $time }}</p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const maxStock = {{ $produk->stok }};

    function incrementQty() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value) || 1;
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
        }
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value) || 1;
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    document.getElementById('quantity')?.addEventListener('change', function() {
        if (this.value > maxStock) this.value = maxStock;
        if (this.value < 1) this.value = 1;
    });
</script>
@endsection
