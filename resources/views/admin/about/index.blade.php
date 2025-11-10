@extends('layouts.admin')

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

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($produk as $item)
                @php
                    $deskripsiRoute = \Illuminate\Support\Facades\Route::has('admin.deskripsi')
                        ? route('admin.deskripsi', $item->id)
                        : '#';
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
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 dark:text-gray-400">No products found</p>
                </div>
            @endforelse
        </div>
    </section>

    <div class="text-center mt-10">
        <a href="{{ route('admin.about.edit') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            ✏️ Edit About
        </a>
    </div>
</div>

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
});
</script>
@endsection
