@extends('layouts.user')

@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: 'Tentang Seilmu',
                text: 'Platform buku digital yang simpel, modern, dan dirancang khusus buat generasi yang haus ilmu!',
                icon: 'info',
                confirmButtonText: 'Lanjut'
            });
        });
    </script>

    <div class="container mx-auto px-6 py-12 text-gray-800">
        <!-- Judul -->
        <h1 class="text-4xl font-extrabold text-blue-900 mb-6 text-center">Tentang <span class="text-blue-600">Seilmu</span></h1>

        <!-- Deskripsi -->
        <p class="text-lg leading-relaxed mb-8 text-center max-w-3xl mx-auto">
            <strong>Seilmu</strong> hadir dengan misi sederhana: bikin akses ke buku jadi lebih mudah, cepat, dan seru.
            Bukan sekadar toko buku online, tapi ruang baru buat kamu yang ingin terus belajar, berkembang, dan menikmati cerita.
        </p>

        <!-- Misi Kami -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-blue-800 mb-3">📘 Misi Kami</h2>
            <p class="text-base leading-relaxed">
                Di era digital ini, kami percaya membaca bukan cuma sekadar hobi, tapi <strong>bagian penting dari gaya hidup</strong>.
                Karena itu, <span class="font-medium text-blue-700">Seilmu</span> berkomitmen untuk menghadirkan buku dalam format yang praktis, nyaman, dan selalu up-to-date.
                Dari buku pelajaran, novel, sampai bacaan populer — semua bisa kamu temukan di sini.
            </p>
        </div>

        <!-- Kenapa Pilih Kami -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-blue-800 mb-3">✨ Kenapa Seilmu?</h2>
            <ul class="list-disc list-inside space-y-2 text-base">
                <li><span class="font-medium">Praktis</span> – cukup lewat smartphone atau laptop, buku favoritmu langsung bisa diakses.</li>
                <li><span class="font-medium">Cepat</span> – sistem simpel, user-friendly, dan anti ribet.</li>
                <li><span class="font-medium">Relevan</span> – koleksi buku dipilih sesuai kebutuhan generasi sekarang.</li>
                <li><span class="font-medium">Tanpa Batas</span> – baca kapan pun, di mana pun, tanpa hambatan.</li>
            </ul>
        </div>

        <!-- Tagline -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-800 mb-3">🚀 Tagline Kami</h2>
            <p class="italic text-lg text-gray-700">
                "Seilmu — Baca, Belajar, Berkembang!"
            </p>
            <p class="mt-3">
                Kami percaya setiap buku adalah jendela menuju peluang baru. Dengan <strong>Seilmu</strong>, kamu bisa membuka pintu ilmu kapan saja.
            </p>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center">
            <a href="{{ route('user.dashboard') }}"
               class="inline-block px-6 py-3 bg-blue-900 text-white rounded-lg shadow-md hover:bg-blue-800 transition">
                ⬅ Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
