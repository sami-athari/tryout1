@extends('layouts.user')

@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: 'Tentang ReadHaus 📚',
                text: 'Tempatnya buku kece, vibes Gen Z, tapi tetap serius bikin kamu makin pinter!',
                icon: 'info',
                confirmButtonColor: '#1d4ed8',
                confirmButtonText: 'Gas Lanjut 🚀'
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out forwards;
        }
    </style>

    <div class="max-w-5xl mx-auto bg-blue-800 bg-opacity-70 rounded-xl p-8 shadow-lg fade-in">
        <h1 class="text-4xl font-bold mb-6 text-center text-blue-200">Tentang ReadHaus</h1>
        
        <p class="text-lg text-white mb-6 leading-relaxed">
            <strong>ReadHaus</strong> lahir dari ide simpel: bikin buku jadi gampang banget diakses siapa aja, kapan aja, dan di mana aja.  
            Bukan cuma toko buku online biasa, ReadHaus itu <em>vibes</em> baru buat kamu yang haus ilmu, inspirasi, dan cerita seru. ✨
        </p>

        <h2 class="text-3xl font-semibold text-blue-100 mb-4">Misi Kami</h2>
        <p class="text-white mb-4 leading-relaxed">
            Di era serba digital, kami percaya membaca itu bukan sekadar hobi, tapi lifestyle.  
            Misi kami simpel tapi dalam: <strong>membawa buku ke layar kamu dengan cara paling mudah, nyaman, dan kekinian</strong>.  
            Dari buku pelajaran sampai novel yang lagi hype, semua ada di sini.
        </p>

        <h2 class="text-3xl font-semibold text-blue-100 mb-4">Kenapa Harus ReadHaus?</h2>
        <ul class="list-disc list-inside text-white mb-6 leading-relaxed">
            <li>📱 Praktis – belanja buku cukup lewat gadget kamu.</li>
            <li>⚡ Cepat – sistem kami simple, nggak ribet, dan anti lelet.</li>
            <li>🎯 Relevan – koleksi buku dipilih sesuai kebutuhan Gen Z & semua generasi.</li>
            <li>🌍 Akses Global – baca buku tanpa batas ruang & waktu.</li>
        </ul>

        <h2 class="text-3xl font-semibold text-blue-100 mb-4">Tagline Kami</h2>
        <p class="text-white leading-relaxed">
            <em>"ReadHaus — Baca Biar Nggak Ketinggalan, Koleksi Ilmu Sebanyak Mungkin!"</em> 🚀📖  
            Kami percaya setiap buku bisa jadi pintu baru buat membuka dunia yang lebih luas.
        </p>

        <div class="mt-10 text-center">
            <a href="{{ route('user.dashboard') }}" class="inline-block px-6 py-3 bg-blue-300 text-blue-900 font-bold rounded-full hover:bg-blue-400 transition">
                ⬅️ Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
