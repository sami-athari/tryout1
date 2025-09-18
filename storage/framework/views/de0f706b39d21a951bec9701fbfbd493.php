<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-16 text-gray-800">
    <!-- Judul -->
    <h1 class="text-6xl font-extrabold text-blue-900 mb-10 text-center drop-shadow-lg">
        <?php echo e($about->title ?? 'Tentang Seilmu'); ?>

    </h1>

    <!-- Gambar -->
    <?php if($about && $about->image): ?>
        <div class="flex justify-center mb-10">
            <img src="<?php echo e(asset('storage/' . $about->image)); ?>"
                 class="h-56 w-56 object-cover rounded-2xl border-4 border-white shadow-2xl">
        </div>
    <?php endif; ?>

    <!-- Deskripsi -->
    <p class="text-xl leading-relaxed mb-14 text-center max-w-4xl mx-auto text-gray-700">
        <?php echo nl2br(e($about->description ?? 'Belum ada deskripsi')); ?>

    </p>

    <!-- Statistik (hiasan) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16 text-center">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2"><?php echo e($totalProduk ?? '120+'); ?></h3>
            <p class="opacity-90 text-lg">Total Produk</p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-600 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2"><?php echo e($userCount ?? '500+'); ?></h3>
            <p class="opacity-90 text-lg">Pengguna Aktif</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-8 rounded-2xl shadow-lg text-white">
            <h3 class="text-5xl font-bold mb-2"><?php echo e($transactionCount ?? '1000+'); ?></h3>
            <p class="opacity-90 text-lg">Buku Terjual</p>
        </div>
    </div>

    <!-- Misi -->
    <div class="mb-14">
        <h2 class="text-4xl font-bold text-blue-800 mb-4">📘 Misi Kami</h2>
        <p class="text-lg text-gray-700"><?php echo e($about->mission ?? 'Belum ada misi.'); ?></p>
    </div>

    <!-- Kenapa -->
    <div class="mb-14">
        <h2 class="text-4xl font-bold text-blue-800 mb-4">✨ Kenapa Seilmu?</h2>
        <p class="text-lg text-gray-700"><?php echo e($about->why ?? 'Belum ada alasan.'); ?></p>
    </div>

    <!-- Tagline -->
    <div class="mb-20 text-center">
        <h2 class="text-4xl font-bold text-blue-800 mb-3">🚀 Tagline Kami</h2>
        <p class="italic text-2xl text-gray-700">
            "<?php echo e($about->tagline ?? 'Belum ada tagline.'); ?>"
        </p>
    </div>

    <!-- Tombol Edit (hanya admin) -->
    <?php if(auth()->guard()->check()): ?>
    <div class="text-center">
        <a href="<?php echo e(route('admin.about.edit', $about->id)); ?>"
           class="px-6 py-3 bg-yellow-500 text-white text-lg rounded-xl shadow hover:bg-yellow-600 transition">
           ✏️ Edit
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/about/index.blade.php ENDPATH**/ ?>