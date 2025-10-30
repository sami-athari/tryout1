@extends('layouts.admin')

@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
        min-height: 100vh;
        overflow-x: hidden;
    }
    .glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-6 py-16 text-gray-800">
    <!-- Judul -->
    <h1 class="text-6xl font-extrabold text-blue-900 mb-10 text-center drop-shadow-lg">
        {{ $about->title ?? 'Tentang Seilmu' }}
    </h1>

    <!-- Gambar -->
    @if($about && $about->image)
        <div class="flex justify-center mb-10">
            <img src="{{ asset('storage/' . $about->image) }}"
                 class="h-80 w-100 object-cover rounded-2xl border-4 border-white shadow-2xl">
        </div>
    @endif


    <!-- Deskripsi dengan Read More -->
    @php
        $desc = $about->description ?? 'Belum ada deskripsi';
        // Pisah jadi kalimat
        $sentences = preg_split('/(?<=[.?!])\s+/', $desc, -1, PREG_SPLIT_NO_EMPTY);
        $showReadMore = count($sentences) > 5;
        $firstPart = implode(' ', array_slice($sentences, 0, 5));
        $remainingPart = implode(' ', array_slice($sentences, 5));
    @endphp

    <div class="text-center max-w-4xl mx-auto mb-14 text-gray-700">
        <p id="shortDesc" class="text-xl leading-relaxed">
            {!! nl2br(e($firstPart)) !!}
            @if($showReadMore)
                <span id="dots">...</span>
            @endif
        </p>
        @if($showReadMore)
            <p id="moreDesc" class="hidden text-xl leading-relaxed">
                {!! nl2br(e($remainingPart)) !!}
            </p>
            <button id="toggleBtn"
                    class="mt-3 text-blue-700 font-semibold hover:underline transition">
                Baca Selengkapnya
            </button>
        @endif
    </div>

    {{-- Produk Section --}}
    <section id="produk" class="container mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-blue-900 border-b-2 border-blue-900 inline-block">
                ✨ Produk Terbaru
            </h3>
        </div>

        <div id="produk-container">
            <div id="produk-page" class="grid gap-8 md:grid-cols-3 lg:grid-cols-4">
                @forelse($produk as $item)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                        <a href="{{ route('user.deskripsi', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->foto) }}"
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
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-4">Tidak ada produk ditemukan.</p>
                @endforelse
            </div>
        </div>

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


    </section>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16 text-center">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2">{{ $totalProduk ?? '120+' }}</h3>
            <p class="opacity-90 text-lg">Total Produk</p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-600 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2">{{ $userCount ?? '500+' }}</h3>
            <p class="opacity-90 text-lg">Pengguna Aktif</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2">{{ $transactionCount ?? '1000+' }}</h3>
            <p class="opacity-90 text-lg">Buku Terjual</p>
        </div>

    </div>

    <!-- Misi -->
    <div class="mb-14">
        <h2 class="text-4xl font-bold text-blue-800 mb-4">📘 Misi Kami</h2>
        <p class="text-lg text-gray-700">{{ $about->mission ?? 'Belum ada misi.' }}</p>
    </div>

    <!-- Kenapa -->
    <div class="mb-14">
        <h2 class="text-4xl font-bold text-blue-800 mb-4">✨ Kenapa Seilmu?</h2>
        <p class="text-lg text-gray-700">{{ $about->why ?? 'Belum ada alasan.' }}</p>
    </div>

    <!-- Tagline -->
    <div class="mb-20 text-center">
        <h2 class="text-4xl font-bold text-blue-800 mb-3">🚀 Tagline Kami</h2>
        <p class="italic text-2xl text-gray-700">
            "{{ $about->tagline ?? 'Belum ada tagline.' }}"
        </p>
    </div>

    <!-- Tombol Edit -->
    @auth
    <div class="text-center">
        {{-- route does not require an id because About is a single record (About::first()) --}}
        <a href="{{ route('admin.about.edit') }}"
           class="px-6 py-3 bg-yellow-500 text-white text-lg rounded-xl shadow hover:bg-yellow-600 transition">
           ✏️ Edit
        </a>
    </div>
    @endauth
</div>

{{-- Script pagination smooth --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector('#produk-container');

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('#nextPage, #prevPage');
        if (!btn) return;

        e.preventDefault();
        const url = btn.id === 'nextPage'
            ? "{{ $produk->nextPageUrl() }}"
            : "{{ $produk->previousPageUrl() }}";

        if (!url) return;

        container.style.opacity = 0.5;

        fetch(url)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#produk-container').innerHTML;
                container.innerHTML = newContent;
                container.style.opacity = 1;
                window.scrollTo({ top: container.offsetTop - 100, behavior: 'smooth' });
            })
            .catch(err => console.error('Gagal memuat halaman:', err));
    });
});
</script>

{{-- Script untuk Read More --}}
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
                toggleBtn.textContent = isHidden ? 'Tutup' : 'Baca Selengkapnya';
            });
        }
    });
</script>
@endsection
