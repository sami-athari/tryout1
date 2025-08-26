<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Readhaus - Toko Buku Online</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Nama Toko -->
    <header>
        <h1>Readhaus</h1>
        <p>Toko Buku Online Terpercaya & Lengkap</p>
    </header>

    <main>

        <!-- Deskripsi -->
        <p>
            Temukan ribuan judul buku dari berbagai genre dengan harga terbaik.
            Mudah, cepat, dan aman berbelanja buku favoritmu kapan saja dan di mana saja.
        </p>

        <!-- Tombol Aksi -->
        <div>
            <button onclick="handleLogin()">Masuk</button>
            <button onclick="handleRegister()">Daftar</button>
        </div>

        <!-- Fitur Utama -->
        <section>
            <h3>Koleksi Lengkap</h3>
            <p>Pilihan buku dari berbagai genre dan penulis terbaik, selalu update dan lengkap.</p>

            <h3>Wishlist & Bookmark</h3>
            <p>Simpan buku favorit dan buat daftar keinginanmu dengan mudah.</p>

            <h3>Pengalaman Membaca</h3>
            <p>Baca online nyaman di semua perangkat dengan tampilan yang responsif dan modern.</p>
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
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        }
    </script>

</body>
</html>
