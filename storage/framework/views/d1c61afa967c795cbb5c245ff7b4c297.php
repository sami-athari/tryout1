<?php $__env->startSection('content'); ?>
<?php
    $query = request('search') ?? '';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="container mx-auto px-6 py-16">
        <!-- Title -->
<h1 class="text-5xl font-bold text-gray-900 mb-8 text-center">
    <?php echo e($about->title ?? 'About Seilmu'); ?>

</h1>

<!-- Image -->
<?php if($about && $about->image): ?>
    <div class="flex justify-center mb-12">
        <img src="<?php echo e(asset('storage/' . $about->image)); ?>"
             alt="About Image"
             class="h-80 w-full object-cover rounded-2xl shadow-xl">
    </div>
<?php endif; ?>

        <!-- Description with Read More -->
        <?php
            $desc = $about->description ?? 'No description available';
            $sentences = preg_split('/(?<=[.?!])\s+/', $desc, -1, PREG_SPLIT_NO_EMPTY);
            $showReadMore = count($sentences) > 5;
            $firstPart = implode(' ', array_slice($sentences, 0, 5));
            $remainingPart = implode(' ', array_slice($sentences, 5));
        ?>

        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto mb-16">
            <p id="shortDesc" class="text-lg text-gray-700 leading-relaxed">
                <?php echo nl2br(e($firstPart)); ?>

                <?php if($showReadMore): ?>
                    <span id="dots">...</span>
                <?php endif; ?>
            </p>
            <?php if($showReadMore): ?>
                <p id="moreDesc" class="hidden text-lg text-gray-700 leading-relaxed mt-4">
                    <?php echo nl2br(e($remainingPart)); ?>

                </p>
                <button id="toggleBtn"
                        class="mt-4 text-blue-600 font-semibold hover:text-blue-700 transition">
                    Read More →
                </button>
            <?php endif; ?>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-blue-600">
                <h3 class="text-4xl font-bold text-gray-900 mb-2"><?php echo e($totalProduk ?? '120+'); ?></h3>
                <p class="text-gray-600">Total Products</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-green-500">
                <h3 class="text-4xl font-bold text-gray-900 mb-2"><?php echo e($userCount ?? '500+'); ?></h3>
                <p class="text-gray-600">Active Users</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-yellow-500">
                <h3 class="text-4xl font-bold text-gray-900 mb-2"><?php echo e(number_format($totalSold)); ?></h3>
                <p class="text-gray-600">Books Sold</p>
            </div>
        </div>

        <!-- Mission -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">📘 Our Mission</h2>
            <p class="text-lg text-gray-700 leading-relaxed"><?php echo e($about->mission ?? 'No mission yet.'); ?></p>
        </div>

        <!-- Why -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">✨ Why Seilmu?</h2>
            <p class="text-lg text-gray-700 leading-relaxed"><?php echo e($about->why ?? 'No reason yet.'); ?></p>
        </div>

        <!-- Tagline -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-12 mb-16 text-center">
            <h2 class="text-3xl font-bold text-white mb-3">🚀 Our Tagline</h2>
            <p class="italic text-2xl text-white">
                "<?php echo e($about->tagline ?? 'No tagline yet.'); ?>"
            </p>
        </div>

        <!-- Products Section -->
        <section id="produk" class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Featured Products</h3>
                    <div class="h-1 w-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full"></div>
                </div>
            </div>

            <?php if(request('search')): ?>
                <div class="mb-6">
                    <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="font-medium">Results for "<?php echo e(request('search')); ?>"</span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $deskripsiRoute = \Illuminate\Support\Facades\Route::has('user.deskripsi')
                            ? route('user.deskripsi', $item->id)
                            : url('/deskripsi/' . $item->id);
                    ?>

                    <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <a href="<?php echo e($deskripsiRoute); ?>" class="block">
                            <div class="relative overflow-hidden aspect-[4/3] bg-gray-100">
                                <img src="<?php echo e($item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png')); ?>"
                                     alt="<?php echo e($item->nama); ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>

                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <?php echo e($item->nama); ?>

                                </h4>

                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl font-bold text-gray-900">
                                        Rp <?php echo e(number_format($item->harga ?? 0, 0, ',', '.')); ?>

                                    </span>
                                </div>

                                <p class="text-sm text-gray-500">
                                    <?php echo e($item->kategori ? $item->kategori->nama : '-'); ?>

                                </p>
                            </div>
                        </a>

                        <div class="px-6 pb-6">
                            <?php if($item->stok > 0): ?>
                                <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="flex items-center gap-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex items-center border border-gray-200 rounded-full overflow-hidden">
                                        <button type="button" class="qty-minus px-3 py-2 hover:bg-gray-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                               class="qty-input w-12 text-center border-0 text-gray-900 font-medium focus:ring-0">
                                        <button type="button" class="qty-plus px-3 py-2 hover:bg-gray-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-full font-medium hover:shadow-lg transition-all transform hover:scale-105">
                                        Add to Cart
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="text-center py-3 bg-red-50 text-red-600 font-medium rounded-full">
                                    Out of Stock
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-20">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-lg">No products found</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Pagination -->
        <?php if($produk->lastPage() > 1): ?>
            <div class="mb-16">
                <nav class="flex justify-center">
                    <div class="flex items-center gap-2 bg-white rounded-full shadow-lg px-4 py-2">
                        <?php if($produk->onFirstPage()): ?>
                            <span class="px-4 py-2 text-gray-300 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($produk->previousPageUrl()); ?>" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php
                            $current = $produk->currentPage();
                            $last = $produk->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);
                        ?>

                        <?php if($start > 1): ?>
                            <a href="<?php echo e($produk->url(1)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium">1</a>
                            <?php if($start > 2): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for($i = $start; $i <= $end; $i++): ?>
                            <?php if($i == $current): ?>
                                <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full font-semibold shadow-md"><?php echo e($i); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($produk->url($i)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium"><?php echo e($i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if($end < $last): ?>
                            <?php if($end < $last - 1): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="<?php echo e($produk->url($last)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium"><?php echo e($last); ?></a>
                        <?php endif; ?>

                        <?php if($produk->hasMorePages()): ?>
                            <a href="<?php echo e($produk->nextPageUrl()); ?>" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-gray-300 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        <?php endif; ?>

        <!-- Back Button -->
        <div class="text-center">
            <a href="<?php echo e(route('user.dashboard')); ?>"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-full font-medium shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<style>
/* Quantity Input Styling */
.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty-input {
    -moz-appearance: textfield;
}

/* Dark mode support */
.dark-mode .bg-gradient-to-br {
    background: linear-gradient(to bottom right, #1e293b, #0f172a, #1e3a8a) !important;
}

.dark-mode .bg-white {
    background-color: #1e293b !important;
}

.dark-mode h1,
.dark-mode h2,
.dark-mode h3,
.dark-mode h4 {
    color: #e2e8f0 !important;
}

.dark-mode .text-gray-900 {
    color: #e2e8f0 !important;
}

.dark-mode .text-gray-700 {
    color: #cbd5e1 !important;
}

.dark-mode .text-gray-600 {
    color: #94a3b8 !important;
}

.dark-mode .text-gray-500 {
    color: #64748b !important;
}

.dark-mode .border-gray-200 {
    border-color: #334155 !important;
}

.dark-mode .bg-gray-100 {
    background-color: #334155 !important;
}

.dark-mode .bg-blue-50 {
    background-color: rgba(59, 130, 246, 0.1) !important;
}

.dark-mode .text-blue-700 {
    color: #60a5fa !important;
}

.dark-mode .hover\:bg-gray-50:hover {
    background-color: #334155 !important;
}

.dark-mode .hover\:bg-blue-50:hover {
    background-color: rgba(59, 130, 246, 0.2) !important;
}

.dark-mode .group:hover h4 {
    color: #60a5fa !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Read More functionality
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

    // Quantity controls
    document.querySelectorAll('.group').forEach(card => {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/about.blade.php ENDPATH**/ ?>