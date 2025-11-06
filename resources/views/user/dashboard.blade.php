@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-white">

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-black text-white py-32 md:py-48 lg:py-56 overflow-hidden">
        <div class="container mx-auto text-center px-6">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 animate-fadeInDown leading-tight">
                Selamat Datang di <span class="text-blue-300">Seilmu</span>
            </h2>
            <p class="text-base sm:text-lg md:text-xl mb-8 animate-fadeInUp max-w-2xl mx-auto text-gray-200">
                Temukan ribuan buku favoritmu dengan berbagai kategori menarik. Semua bisa kamu jelajahi dengan mudah dan cepat.
            </p>
            <a href="#produk"
               class="inline-block bg-white text-blue-900 font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-gray-100 transition transform hover:scale-105 animate-bounce">
               Mulai Belanja
            </a>
        </div>
        <div class="absolute inset-0 bg-[url('/images/book-pattern.svg')] opacity-10 bg-cover bg-center"></div>
    </section>

    {{-- Produk Section --}}
    <section id="produk" class="container mx-auto px-4 sm:px-6 py-12">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-4 text-center sm:text-left">
            <h3 class="text-2xl font-bold text-blue-900 border-b-4 border-blue-900 inline-block pb-1">
                ✨ Produk Terbaru
            </h3>
        </div>

        @if(request('search'))
            <p class="mb-6 text-gray-600 text-center sm:text-left">
                Hasil pencarian untuk:
                <span class="font-semibold">"{{ request('search') }}"</span>
            </p>
        @endif

        <div class="grid gap-6 sm:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" id="productGrid">
            @forelse($produk as $item)
                @php
                    if (\Illuminate\Support\Facades\Route::has('user.produk.show')) {
                        $deskripsiRoute = route('user.produk.show', $item->id);
                    } elseif (\Illuminate\Support\Facades\Route::has('user.deskripsi')) {
                        $deskripsiRoute = route('user.deskripsi', $item->id);
                    } else {
                        $deskripsiRoute = url('/deskripsi/' . $item->id);
                    }

                    $imageSrc = $item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png');
                    $priceNumeric = (int) $item->harga;
                    $sold = (int) ($item->transaction_count ?? 0);

                    if ($sold >= 1000000) {
                        $soldLabel = number_format($sold / 1000000, 1) . 'M+';
                    } elseif ($sold >= 1000) {
                        $soldLabel = number_format($sold / 1000, 1) . 'k+';
                    } else {
                        $soldLabel = (string) $sold;
                    }

                    $rating = number_format($item->average_rating ?? ($item->reviews->avg('rating') ?? 0), 1);
                @endphp

                <div class="relative product-card bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300"
                     data-price="{{ $priceNumeric }}">

                    {{-- Wishlist --}}
                    <div class="absolute top-3 right-3 z-10">
                        <button type="button"
                                class="add-wishlist-local inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/80 hover:bg-white focus:outline-none transition"
                                data-id="{{ $item->id }}">
                            <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M20.8 8.6c-.9-2-3-3.3-5.3-3.3-1.5 0-2.9.6-3.9 1.6L12 6.8l-.6-.6C9.9 5 8.5 4.4 7 4.4 4.7 4.4 2.6 5.6 1.7 7.6c-1 2.3-.2 5 1.9 7.1L12 21l8.4-6.3c2.1-2.1 2.9-4.8 1.9-7.1z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <a href="{{ $deskripsiRoute }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ $imageSrc }}" alt="{{ $item->nama }}"
                                 class="w-full aspect-[4/3] object-cover rounded-t-xl transition-transform duration-300 hover:scale-105">
                        </div>

                        <div class="p-4">
                            <h4 class="text-lg sm:text-xl font-semibold text-gray-800 line-clamp-2">{{ $item->nama }}</h4>
                            <p class="text-lg sm:text-xl font-bold text-blue-900 mt-1">
                                Rp {{ number_format($item->harga ?? 0,0,',','.') }}
                            </p>
                            <div class="flex items-center text-sm text-gray-600 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568L24 9.423l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.27 0 9.423l8.332-1.268z"/>
                                </svg>
                                <span class="font-medium">⭐ {{ $rating }}</span>
                                <span class="mx-1">•</span>
                                <span class="text-sm">{{ $soldLabel }} terjual</span>
                            </div>
                        </div>
                    </a>

                    <div class="px-4 pb-4">
                        @if($item->stok > 0)
                            <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-3 flex items-center space-x-2">
                                @csrf
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}"
                                       class="w-16 border border-gray-300 rounded text-center text-black focus:ring focus:ring-blue-200">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                                    + Keranjang
                                </button>
                            </form>
                        @else
                            <p class="mt-3 text-red-500 font-semibold">Stok Habis</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-600 col-span-full text-center">Tidak ada buku ditemukan.</p>
            @endforelse
        </div>
    </section>

    {{-- Pagination --}}
    @if ($produk->lastPage() > 1)
        <div class="mt-10 flex justify-center">
            <nav class="flex flex-wrap items-center justify-center gap-2 bg-white/70 backdrop-blur-md px-4 py-2 rounded-xl shadow-md">
                @if ($produk->onFirstPage())
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $produk->previousPageUrl() }}"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">‹</a>
                @endif

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

                @if ($produk->hasMorePages())
                    <a href="{{ $produk->nextPageUrl() }}"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">›</a>
                @else
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">›</span>
                @endif
            </nav>
        </div>
    @endif

    <footer class="bg-blue-900 text-white text-center py-6 mt-12">
        <p>&copy; {{ date('Y') }} Seilmu. All rights reserved.</p>
    </footer>
</div>

{{-- Dropdown Menu Animation --}}
<style>
.options-menu {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.25s ease;
}
.options-menu.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown option menu handler
    document.querySelectorAll('.options-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.options-menu').forEach(m => {
                if (m !== menu) m.classList.remove('active');
            });
            menu.classList.toggle('active');
        });
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('.options-menu') && !e.target.closest('.options-btn')) {
            document.querySelectorAll('.options-menu').forEach(m => m.classList.remove('active'));
        }
    });

    // Wishlist lokal (non-login)
    document.querySelectorAll('.add-wishlist-local').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            if (!id) return;
            try {
                const key = 'seilmu_wishlist';
                const raw = localStorage.getItem(key);
                let list = raw ? JSON.parse(raw) : [];

                if (!list.find(i => String(i.id) === String(id))) {
                    list.push({ id: id, added_at: new Date().toISOString() });
                    localStorage.setItem(key, JSON.stringify(list));

                    this.innerHTML = '<svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7.5-4.35-10-7.1C-1.2 9.6 3.2 4 8.9 7.1 12 9 12 9 12 9s0 0 3.1-1.9C20.8 4 25.2 9.6 22 13.9 19.5 16.65 12 21 12 21z"/></svg>';

                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Produk ditambahkan ke wishlist (lokal).',
                            showConfirmButton: false,
                            timer: 1800
                        });
                    }
                } else {
                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Produk sudah ada di wishlist.',
                            showConfirmButton: false,
                            timer: 1400
                        });
                    }
                }
            } catch (err) {
                console.error('Wishlist local error', err);
            }
        });
    });
});
</script>
@endsection
