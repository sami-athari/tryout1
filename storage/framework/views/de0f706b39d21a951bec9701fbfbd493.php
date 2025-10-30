<?php $__env->startSection('styles'); ?>
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
                 class="h-80 w-100 object-cover rounded-2xl border-4 border-white shadow-2xl">
        </div>
    <?php endif; ?>


    <!-- Deskripsi dengan Read More -->
    <?php
        $desc = $about->description ?? 'Belum ada deskripsi';
        // Pisah jadi kalimat
        $sentences = preg_split('/(?<=[.?!])\s+/', $desc, -1, PREG_SPLIT_NO_EMPTY);
        $showReadMore = count($sentences) > 5;
        $firstPart = implode(' ', array_slice($sentences, 0, 5));
        $remainingPart = implode(' ', array_slice($sentences, 5));
    ?>

    <div class="text-center max-w-4xl mx-auto mb-14 text-gray-700">
        <p id="shortDesc" class="text-xl leading-relaxed">
            <?php echo nl2br(e($firstPart)); ?>

            <?php if($showReadMore): ?>
                <span id="dots">...</span>
            <?php endif; ?>
        </p>
        <?php if($showReadMore): ?>
            <p id="moreDesc" class="hidden text-xl leading-relaxed">
                <?php echo nl2br(e($remainingPart)); ?>

            </p>
            <button id="toggleBtn"
                    class="mt-3 text-blue-700 font-semibold hover:underline transition">
                Baca Selengkapnya
            </button>
        <?php endif; ?>
    </div>

    
    <section id="produk" class="container mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-blue-900 border-b-2 border-blue-900 inline-block">
                ✨ Produk Terbaru
            </h3>
        </div>

        <div id="produk-container">
            <div id="produk-page" class="grid gap-8 md:grid-cols-3 lg:grid-cols-4">
                <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                        <a href="<?php echo e(route('user.deskripsi', $item->id)); ?>">
                            <img src="<?php echo e(asset('storage/' . $item->foto)); ?>"
                                 alt="<?php echo e($item->nama); ?>"
                                 class="w-full h-48 object-cover rounded-t">
                            <div class="p-4">
                                <h4 class="text-lg font-semibold"><?php echo e($item->nama); ?></h4>
                            </div>
                        </a>
                        <div class="px-4 pb-4">
                            <p class="text-xl font-bold text-blue-900 mt-2">
                                Rp <?php echo e(number_format($item->harga,0,',','.')); ?>

                            </p>
                            <p class="text-gray-500 text-sm">Kategori: <?php echo e($item->kategori ? $item->kategori->nama : '-'); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-600 col-span-4">Tidak ada produk ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>

       
    <?php if($produk->lastPage() > 1): ?>
        <div class="mt-10 flex justify-center">
            <nav class="flex items-center space-x-2 bg-white/70 backdrop-blur-md px-4 py-2 rounded-xl shadow-md">
                
                <?php if($produk->onFirstPage()): ?>
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">‹</span>
                <?php else: ?>
                    <a href="<?php echo e($produk->previousPageUrl()); ?>"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                       ‹
                    </a>
                <?php endif; ?>

                
                <?php
                    $current = $produk->currentPage();
                    $last = $produk->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                ?>

                <?php if($start > 1): ?>
                    <a href="<?php echo e($produk->url(1)); ?>" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md">1</a>
                    <?php if($start > 2): ?>
                        <span class="text-gray-500">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $current): ?>
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-md font-semibold shadow"><?php echo e($i); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($produk->url($i)); ?>" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md transition"><?php echo e($i); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if($end < $last): ?>
                    <?php if($end < $last - 1): ?>
                        <span class="text-gray-500">...</span>
                    <?php endif; ?>
                    <a href="<?php echo e($produk->url($last)); ?>" class="px-3 py-1 text-blue-700 hover:bg-blue-100 rounded-md"><?php echo e($last); ?></a>
                <?php endif; ?>

                
                <?php if($produk->hasMorePages()): ?>
                    <a href="<?php echo e($produk->nextPageUrl()); ?>"
                       class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                       ›
                    </a>
                <?php else: ?>
                    <span class="px-3 py-1.5 text-gray-400 cursor-not-allowed select-none">›</span>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>


    </section>

    <!-- Statistik -->
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

    <!-- Tombol Edit -->
    <?php if(auth()->guard()->check()): ?>
    <div class="text-center">
        <a href="<?php echo e(route('admin.about.edit', $about->id)); ?>"
           class="px-6 py-3 bg-yellow-500 text-white text-lg rounded-xl shadow hover:bg-yellow-600 transition">
           ✏️ Edit
        </a>
    </div>
    <?php endif; ?>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector('#produk-container');

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('#nextPage, #prevPage');
        if (!btn) return;

        e.preventDefault();
        const url = btn.id === 'nextPage'
            ? "<?php echo e($produk->nextPageUrl()); ?>"
            : "<?php echo e($produk->previousPageUrl()); ?>";

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/about/index.blade.php ENDPATH**/ ?>