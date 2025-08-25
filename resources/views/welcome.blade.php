<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Readhaus - Toko Buku Online</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            /* Background lebih terang dan soft */
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        }

        /* Nama toko tanpa efek glow */
        .readhaus-logo {
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 3.5rem;
            color: #2563eb; /* biru lebih pekat tapi tanpa glow */
            letter-spacing: 0.12em;
        }

        .readhaus-tagline {
            font-family: 'Poppins', sans-serif;
            color: #4f46e5; /* warna biru yang lebih gelap tapi kalem */
            font-weight: 500;
            font-size: 1.2rem;
            letter-spacing: 0.05em;
        }

        button:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center text-gray-900 px-6">

    <!-- Nama Toko -->
    <header class="mb-12 text-center select-none">
        <h1 class="readhaus-logo">Readhaus</h1>
        <p class="readhaus-tagline mt-1">Toko Buku Online Terpercaya & Lengkap</p>
    </header>

    <main class="max-w-4xl w-full text-center">

        <!-- Icon Buku Besar -->
        <div class="mb-8">
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Book Store Icon" class="w-28 mx-auto drop-shadow-lg" />
        </div>

        <!-- Deskripsi -->
        <p class="text-lg md:text-xl text-gray-800 max-w-3xl mx-auto mb-12 leading-relaxed font-semibold">
            Temukan ribuan judul buku dari berbagai genre dengan harga terbaik. Mudah, cepat, dan aman berbelanja buku favoritmu kapan saja dan di mana saja.
        </p>

        <!-- Tombol Aksi -->
        <div class="flex justify-center gap-8">
            <button 
                onclick="handleLogin()" 
                class="bg-blue-600 hover:bg-blue-700 transition rounded-full px-8 py-3 font-bold text-white shadow-lg shadow-blue-600/50"
            >
                Masuk
            </button>
            <button 
                onclick="handleRegister()" 
                class="bg-white hover:bg-gray-200 transition rounded-full px-8 py-3 font-semibold text-blue-700 shadow-md"
            >
                Daftar
            </button>
        </div>

        <!-- Fitur Utama -->
        <section class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-10">

            <div class="bg-white bg-opacity-80 p-7 rounded-2xl shadow-lg flex flex-col items-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1827/1827323.png" alt="Koleksi Buku" class="w-14 mb-5" />
                <h3 class="text-xl font-semibold text-blue-600 mb-2">Koleksi Lengkap</h3>
                <p class="text-blue-700 text-sm font-medium">
                    Pilihan buku dari berbagai genre dan penulis terbaik, selalu update dan lengkap.
                </p>
            </div>

            <div class="bg-white bg-opacity-80 p-7 rounded-2xl shadow-lg flex flex-col items-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2995/2995223.png" alt="Bookmark" class="w-14 mb-5" />
                <h3 class="text-xl font-semibold text-blue-600 mb-2">Wishlist & Bookmark</h3>
                <p class="text-blue-700 text-sm font-medium">
                    Simpan buku favorit dan buat daftar keinginanmu dengan mudah.
                </p>
            </div>

            <div class="bg-white bg-opacity-80 p-7 rounded-2xl shadow-lg flex flex-col items-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4221/4221433.png" alt="Mode Baca" class="w-14 mb-5" />
                <h3 class="text-xl font-semibold text-blue-600 mb-2">Pengalaman Membaca</h3>
                <p class="text-blue-700 text-sm font-medium">
                    Baca online nyaman di semua perangkat dengan tampilan yang responsif dan modern.
                </p>
            </div>

        </section>
    </main>

    <script>
        function handleLogin() {
            Swal.fire({
                title: 'Masuk ke Akun Anda',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb',
                background: '#fff',
                color: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        function handleRegister() {
            Swal.fire({
                title: 'Buat Akun Baru',
                text: 'Daftar sekarang dan mulai belanja buku favoritmu!',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Daftar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb',
                background: '#fff',
                color: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        }
    </script>

</body>
</html>
