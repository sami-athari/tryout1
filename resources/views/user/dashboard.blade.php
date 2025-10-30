@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-white">

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-black text-white py-64 overflow-hidden">
        <div class="container mx-auto text-center px-6">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fadeInDown">
                Selamat Datang di Seilmu
            </h2>
            <p class="text-lg md:text-xl mb-6 animate-fadeInUp">
                Temukan ribuan buku favoritmu dengan berbagai kategori menarik.
            </p>
            <a href="#produk" class="bg-white text-blue-900 font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-gray-100 transition animate-bounce">
                Mulai Belanja
            </a>
        </div>
    </section>

    {{-- Produk Section --}}
    <section id="produk" class="container mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-blue-900 border-b-2 border-blue-900 inline-block">
                ✨ Produk Terbaru
            </h3>
        </div>


        {{-- Jika ada hasil pencarian --}}
        @if(request('search'))
            <p class="mb-6 text-gray-600">
                Hasil pencarian untuk:
                <span class="font-semibold">"{{ request('search') }}"</span>
            </p>
        @endif

        <div class="grid gap-8 md:grid-cols-3 lg:grid-cols-4" id="productGrid">
            @forelse($produk as $item)
                @php
                    // use named route if available, otherwise fall back to a safe URL
                    $deskripsiRoute = \Illuminate\Support\Facades\Route::has('user.deskripsi')
                        ? route('user.deskripsi', $item->id)
                        : url('/deskripsi/' . $item->id);
                    $imageSrc = $item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png');
                    $priceNumeric = (int) $item->harga;
                @endphp

                <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300"
                     data-price="{{ $priceNumeric }}">

                    {{-- Klik produk menuju halaman detail --}}
                    <a href="{{ $deskripsiRoute }}">
                        <img src="{{ $imageSrc }}"
                             alt="{{ $item->nama }}"
                             class="w-full h-48 object-cover rounded-t">
                        <div class="p-4">
                            <h4 class="text-lg font-semibold">{{ $item->nama }}</h4>
                        </div>
                    </a>

                    <div class="px-4 pb-4">
                        <p class="text-xl font-bold text-blue-900 mt-2">
                            Rp {{ number_format($item->harga,0,',','.') }}
                        </p>
                        <p class="text-gray-500 text-sm">Kategori: {{ $item->kategori ? $item->kategori->nama : '-' }}</p>

                        @if($item->stok > 0)
                            <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-4 flex items-center space-x-2">
                                @csrf
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}"
                                       class="w-16 border rounded text-center text-black">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                                    + Keranjang
                                </button>
                            </form>
                        @else
                            <p class="mt-4 text-red-500 font-semibold">Stok Habis</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-600 col-span-4">Tidak ada buku ditemukan.</p>
            @endforelse
        </div>
    </section>
 {{-- Pagination (modern, center) --}}
    @if ($produk->lastPage() > 1)
        <div class="mt-10 flex justify-center">
            <nav class="flex items-center space-x-2 bg-white/70 backdrop-blur-md px-4 py-2 rounded-xl shadow-md">
                {{-- Tombol Prev --}}
                @if ($produk->onFirstPage())
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $produk->previousPageUrl() }}"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                       ‹
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @php
                    $current = $produk->currentPage();
                    $last = $produk->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if ($start > 1)
                    <a href="{{ $produk->url(1) }}" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md">1</a>
                    @if ($start > 2)
                        <span class="text-gray-500">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $current)
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-md font-semibold shadow">{{ $i }}</span>
                    @else
                        <a href="{{ $produk->url($i) }}" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md transition">{{ $i }}</a>
                    @endif
                @endfor

                @if ($end < $last)
                    @if ($end < $last - 1)
                        <span class="text-gray-500">...</span>
                    @endif
                    <a href="{{ $produk->url($last) }}" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md">{{ $last }}</a>
                @endif

                {{-- Tombol Next --}}
                @if ($produk->hasMorePages())
                    <a href="{{ $produk->nextPageUrl() }}"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                       ›
                    </a>
                @else
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">›</span>
                @endif
            </nav>
        </div>
    @endif

    {{-- Footer --}}
    <footer class="bg-blue-900 text-white text-center py-6 mt-12">
        <p>&copy; {{ date('Y') }} Seilmu. All rights reserved.</p>
    </footer>
</div>

{{-- Animasi sederhana --}}
<style>
@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeInDown {
    animation: fadeInDown 1s ease forwards;
}
.animate-fadeInUp {
    animation: fadeInUp 1s ease forwards;
}
</style>

{{-- Client-side filter & sort fallback --}}
<script>
    (function(){
        const params = new URLSearchParams(window.location.search);
        const sort = params.get('sort_harga'); // 'asc' or 'desc'
        const min = params.has('price_min') ? parseInt(params.get('price_min')) : null;
        const max = params.has('price_max') ? parseInt(params.get('price_max')) : null;

        const grid = document.getElementById('productGrid');
        if (!grid) return;

        // Collect product nodes
        const items = Array.from(grid.querySelectorAll('.product-card'));

        // Filter by price range if provided
        const filtered = items.filter(el => {
            const price = parseInt(el.dataset.price || 0);
            if (min !== null && !isNaN(min) && price < min) return false;
            if (max !== null && !isNaN(max) && price > max) return false;
            return true;
        });

        // Sort if requested (client-side fallback)
        if (sort === 'asc' || sort === 'desc') {
            filtered.sort((a,b) => {
                const pa = parseInt(a.dataset.price || 0);
                const pb = parseInt(b.dataset.price || 0);
                return sort === 'asc' ? pa - pb : pb - pa;
            });
        }

        // Clear and re-append nodes in order
        grid.innerHTML = '';
        if (filtered.length === 0) {
            grid.innerHTML = '<p class="text-gray-600 col-span-4">Tidak ada buku ditemukan.</p>';
        } else {
            filtered.forEach(n => grid.appendChild(n));
        }
    })();
</script>
@endsection
