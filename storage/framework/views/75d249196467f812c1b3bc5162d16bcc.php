<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
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
        <h1 class="text-5xl font-extrabold text-blue-900 mb-6 text-center">
            Tentang <span class="text-blue-600">Seilmu</span>
        </h1>

        <!-- Deskripsi -->
        <p class="text-lg leading-relaxed mb-10 text-center max-w-3xl mx-auto">
            <strong>Seilmu</strong> hadir dengan misi sederhana: bikin akses ke buku jadi lebih mudah, cepat, dan seru.
            Bukan sekadar toko buku online, tapi ruang baru buat kamu yang ingin terus belajar, berkembang, dan menikmati cerita.
        </p>

        
        <div class="mb-14">
            <h2 class="text-3xl font-semibold text-blue-800 mb-6 text-center">🔥 Buku Paling Laris</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition transform">
                        <img src="<?php echo e(asset('storage/' . $item->foto)); ?>"
                             alt="<?php echo e($item->nama); ?>"
                             class="w-full h-56 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-blue-900"><?php echo e($item->nama); ?></h3>
                            <p class="text-sm text-gray-600">Rp <?php echo e(number_format($item->harga,0,',','.')); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-600 text-center col-span-3">Belum ada produk terlaris.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-14 text-center">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-6 rounded-2xl shadow-lg text-white">
                <h3 class="text-4xl font-bold mb-1"><?php echo e($totalProduk); ?></h3>
                <p class="opacity-90">Total Produk</p>
            </div>
            <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-2xl shadow-lg text-white">
                <h3 class="text-4xl font-bold mb-1"><?php echo e($userCount); ?></h3>
                <p class="opacity-90">Pengguna Aktif</p>
            </div>
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 rounded-2xl shadow-lg text-white">
                <h3 class="text-4xl font-bold mb-1"><?php echo e($transactionCount); ?></h3>
                <p class="opacity-90">Buku Terjual</p>
            </div>
        </div>

        <!-- Misi Kami -->
        <div class="mb-12">
            <h2 class="text-3xl font-semibold text-blue-800 mb-4">📘 Misi Kami</h2>
            <p class="text-base leading-relaxed">
                Di era digital ini, kami percaya membaca bukan cuma sekadar hobi, tapi <strong>bagian penting dari gaya hidup</strong>.
                Karena itu, <span class="font-medium text-blue-700">Seilmu</span> berkomitmen untuk menghadirkan buku dalam format yang praktis, nyaman, dan selalu up-to-date.
                Dari buku pelajaran, novel, sampai bacaan populer — semua bisa kamu temukan di sini.
            </p>
        </div>

        <!-- Kenapa Pilih Kami -->
        <div class="mb-12">
            <h2 class="text-3xl font-semibold text-blue-800 mb-4">✨ Kenapa Seilmu?</h2>
            <ul class="list-disc list-inside space-y-2 text-base">
                <li><span class="font-medium">Praktis</span> – cukup lewat smartphone atau laptop, buku favoritmu langsung bisa diakses.</li>
                <li><span class="font-medium">Cepat</span> – sistem simpel, user-friendly, dan anti ribet.</li>
                <li><span class="font-medium">Relevan</span> – koleksi buku dipilih sesuai kebutuhan generasi sekarang.</li>
                <li><span class="font-medium">Tanpa Batas</span> – baca kapan pun, di mana pun, tanpa hambatan.</li>
            </ul>
        </div>

        <!-- Tagline -->
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-semibold text-blue-800 mb-3">🚀 Tagline Kami</h2>
            <p class="italic text-xl text-gray-700">
                "Seilmu — Baca, Belajar, Berkembang!"
            </p>
            <p class="mt-3 text-gray-700 max-w-2xl mx-auto">
                Kami percaya setiap buku adalah jendela menuju peluang baru. Dengan <strong>Seilmu</strong>, kamu bisa membuka pintu ilmu kapan saja.
            </p>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center">
            <a href="<?php echo e(route('user.dashboard')); ?>"
               class="inline-block px-8 py-4 bg-blue-900 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-blue-800 transition">
                ⬅ Kembali ke Beranda
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/about.blade.php ENDPATH**/ ?>