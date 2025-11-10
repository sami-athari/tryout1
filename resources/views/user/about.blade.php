@extends('layouts.user')

@section('content')
@php
    $query = request('search') ?? '';
@endphp

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center dark:text-white">
        {{ $about->title ?? 'About Seilmu' }}
    </h1>

    @if($about && $about->image)
        <div class="mb-8">
            <img src="{{ asset('storage/' . $about->image) }}"
                 alt="About Image"
                 class="w-full h-64 object-cover rounded-lg">
        </div>
    @endif

    @php
        $desc = $about->description ?? 'No description available';
        $sentences = preg_split('/(?<=[.?!])\s+/', $desc, -1, PREG_SPLIT_NO_EMPTY);
        $showReadMore = count($sentences) > 5;
        $firstPart = implode(' ', array_slice($sentences, 0, 5));
        $remainingPart = implode(' ', array_slice($sentences, 5));
    @endphp

    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-8">
        <p id="shortDesc" class="text-gray-700 dark:text-gray-300 leading-relaxed">
            {!! nl2br(e($firstPart)) !!}
            @if($showReadMore)
                <span id="dots">...</span>
            @endif
        </p>
        @if($showReadMore)
            <p id="moreDesc" class="hidden text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                {!! nl2br(e($remainingPart)) !!}
            </p>
            <button id="toggleBtn"
                    class="mt-4 text-blue-600 dark:text-blue-400 hover:underline">
                Read More →
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 text-center">
            <h3 class="text-3xl font-bold mb-2 dark:text-white">{{ $totalProduk ?? '120+' }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Total Products</p>
        </div>
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 text-center">
            <h3 class="text-3xl font-bold mb-2 dark:text-white">{{ $userCount ?? '500+' }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Active Users</p>
        </div>
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 text-center">
            <h3 class="text-3xl font-bold mb-2 dark:text-white">{{ number_format($totalSold) }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Books Sold</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-3 dark:text-white">📘 Our Mission</h2>
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $about->mission ?? 'No mission yet.' }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-3 dark:text-white">✨ Why Seilmu?</h2>
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $about->why ?? 'No reason yet.' }}</p>
    </div>

    <div class="bg-blue-600 text-white rounded-lg p-8 mb-8 text-center">
        <h2 class="text-2xl font-bold mb-2">🚀 Our Tagline</h2>
        <p class="italic text-lg">
            "{{ $about->tagline ?? 'No tagline yet.' }}"
        </p>
    </div>

    <section id="produk" class="mb-8">
        <h3 class="text-2xl font-bold mb-6 dark:text-white">Featured Products</h3>

        @if(request('search'))
            <div class="mb-6">
                <span class="inline-flex items-center gap-2 bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Results for "{{ request('search') }}"</span>
                </span>
            </div>
        @endif

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($produk as $item)
                @php
                    $deskripsiRoute = \Illuminate\Support\Facades\Route::has('user.deskripsi')
                        ? route('user.deskripsi', $item->id)
                        : url('/deskripsi/' . $item->id);
                @endphp

                <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <a href="{{ $deskripsiRoute }}">
                        <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png') }}"
                             alt="{{ $item->nama }}"
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold mb-2 line-clamp-2 dark:text-white">{{ $item->nama }}</h4>
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mb-1">
                                Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $item->kategori ? $item->kategori->nama : '-' }}
                            </p>
                        </div>
                    </a>

                    <div class="p-4 pt-0">
                        @if($item->stok > 0)
                            <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="flex items-center gap-3">
                                @csrf
                                <div class="flex items-center border dark:border-gray-600 rounded-lg overflow-hidden">
                                    <button type="button" class="qty-minus px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white">−</button>
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}"
                                           class="qty-input w-12 text-center border-0 dark:bg-gray-800 dark:text-white">
                                    <button type="button" class="qty-plus px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white">+</button>
                                </div>
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <div class="text-center py-2 bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-300 rounded-lg">
                                Out of Stock
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 dark:text-gray-400">No products found</p>
                </div>
            @endforelse
        </div>
    </section>

    @if ($produk->lastPage() > 1)
        <div class="mb-8">
            <nav class="flex justify-center">
                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg px-4 py-2">
                    @if ($produk->onFirstPage())
                        <span class="px-3 py-2 text-gray-300 dark:text-gray-600">←</span>
                    @else
                        <a href="{{ $produk->previousPageUrl() }}" class="px-3 py-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-700 rounded">←</a>
                    @endif

                    @php
                        $current = $produk->currentPage();
                        $last = $produk->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $produk->url(1) }}" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $current)
                            <span class="px-3 py-2 bg-blue-600 text-white rounded font-semibold">{{ $i }}</span>
                        @else
                            <a href="{{ $produk->url($i) }}" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $produk->url($last) }}" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded">{{ $last }}</a>
                    @endif

                    @if ($produk->hasMorePages())
                        <a href="{{ $produk->nextPageUrl() }}" class="px-3 py-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-700 rounded">→</a>
                    @else
                        <span class="px-3 py-2 text-gray-300 dark:text-gray-600">→</span>
                    @endif
                </div>
            </nav>
        </div>
    @endif

    <div class="text-center">
        <a href="{{ route('user.dashboard') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            ← Back to Dashboard
        </a>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty-input {
    -moz-appearance: textfield;
    appearance: textfield;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleBtn');
    const moreText = document.getElementById('moreDesc');
    const dots = document.getElementById('dots');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isHidden = moreText.classList.contains('hidden');
            moreText.classList.toggle('hidden');
            dots.classList.toggle('hidden');
            toggleBtn.textContent = isHidden ? '← Close' : 'Read More →';
        });
    }

    document.querySelectorAll('.group, .bg-white.border').forEach(card => {
        const minusBtn = card.querySelector('.qty-minus');
        const plusBtn = card.querySelector('.qty-plus');
        const input = card.querySelector('.qty-input');

        if (minusBtn && input) {
            minusBtn.addEventListener('click', () => {
                const val = parseInt(input.value) || 1;
                if (val > parseInt(input.min)) input.value = val - 1;
            });
        }

        if (plusBtn && input) {
            plusBtn.addEventListener('click', () => {
                const val = parseInt(input.value) || 1;
                const max = parseInt(input.max);
                if (val < max) input.value = val + 1;
            });
        }
    });
});
</script>
@endsection
