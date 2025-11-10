<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6 dark:text-white">Riwayat Transaksi</h2>

    <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="font-semibold text-gray-700 dark:text-gray-300">Invoice: #<?php echo e($trx->id); ?></p>

                <p class="mt-2">
                    <span class="font-medium">Status:</span>
                    <?php if($trx->status === 'pending'): ?>
                        <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">Pending</span>
                    <?php elseif($trx->status === 'dikirim'): ?>
                        <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">Dikirim</span>
                    <?php elseif($trx->status === 'selesai'): ?>
                        <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">Selesai</span>
                    <?php elseif($trx->status === 'dibatalkan'): ?>
                        <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">Dibatalkan</span>
                    <?php endif; ?>
                </p>

                <?php if($trx->shipping_note): ?>
                <div class="mt-3 px-4 py-3 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Catatan Admin:</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        <?php echo e($trx->shipping_note); ?>

                    </p>
                </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-3">
                <?php if($trx->status !== 'pending'): ?>
                    <a href="<?php echo e(route('user.struk', $trx->id)); ?>"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                        Lihat Struk
                    </a>
                <?php endif; ?>

                <?php if($trx->status === 'dikirim'): ?>
                    <form method="POST" action="<?php echo e(route('user.transactions.selesai', $trx->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                            Terima
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if($trx->status === 'selesai'): ?>
        <div class="mt-6 border-t dark:border-gray-700 pt-4">
            <h4 class="font-semibold mb-3 dark:text-white">Berikan Review Produk</h4>

            <?php if($trx->items->isEmpty()): ?>
                <p class="text-sm text-gray-500">Tidak ada produk pada transaksi ini.</p>
            <?php else: ?>
                <?php $__currentLoopData = $trx->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $reviewQuery = \App\Models\Review::where('produk_id', $item->produk_id)
                            ->where('user_id', auth()->id());

                        if (\Illuminate\Support\Facades\Schema::hasColumn('reviews', 'transaction_id')) {
                            $reviewQuery->where('transaction_id', $trx->id);
                        }

                        $alreadyReviewed = $reviewQuery->exists();
                    ?>

                    <div class="border p-4 rounded-lg mb-3 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <p class="font-medium text-gray-700"><?php echo e($item->produk->nama ?? 'Produk tidak ditemukan'); ?></p>

                            <?php if(!$alreadyReviewed): ?>
                                <button onclick="openReviewModal(<?php echo e($item->produk_id); ?>, <?php echo e($trx->id); ?>)"
                                    class="text-blue-600 font-semibold hover:underline text-sm">
                                    Beri Review ⭐
                                </button>
                            <?php else: ?>
                                <p class="text-sm text-green-600">✅ Sudah direview</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-500 dark:text-gray-400 text-center">Belum ada transaksi yang tercatat.</p>
    <?php endif; ?>
</div>

<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-lg p-6 relative">
        <button onclick="closeReviewModal()" class="absolute top-3 right-3 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">✖</button>

        <h3 class="text-xl font-semibold mb-4 dark:text-white">Beri Penilaian Produk</h3>

        <form id="reviewForm" action="<?php echo e(route('user.review.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="produk_id" id="produk_id">

            <?php if(\Illuminate\Support\Facades\Schema::hasColumn('reviews', 'transaction_id')): ?>
                <input type="hidden" name="transaction_id" id="transaction_id">
            <?php endif; ?>

            <div class="flex items-center mb-3 space-x-2 justify-center">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <svg onclick="setRating(<?php echo e($i); ?>)"
                        id="star-<?php echo e($i); ?>"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-10 h-10 text-gray-400 cursor-pointer hover:text-yellow-400 transition">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.5a.75.75 0 011.04 0l2.27 2.18a.75.75 0 00.56.25h3.18a.75.75 0 01.44 1.36l-2.57 2.11a.75.75 0 00-.25.68l.86 3.45a.75.75 0 01-1.1.82l-2.92-1.73a.75.75 0 00-.78 0l-2.92 1.73a.75.75 0 01-1.1-.82l.86-3.45a.75.75 0 00-.25-.68L6.03 7.29A.75.75 0 016.47 6h3.18a.75.75 0 00.56-.25l2.27-2.18z" />
                    </svg>
                <?php endfor; ?>
            </div>

            <input type="hidden" name="rating" id="rating" required>

            <label class="block text-sm font-medium mb-1">Komentar</label>
            <textarea name="komentar" rows="3" placeholder="Tulis ulasan kamu..."
                class="border rounded-lg w-full px-3 py-2 mb-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>

            <label class="block text-sm font-medium mb-1">Gambar (opsional)</label>
            <input type="file" name="gambar" accept="image/*"
                class="border rounded-lg px-3 py-2 w-full mb-4">

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Kirim Review
            </button>
        </form>
    </div>
</div>

<script>
let currentRating = 0;

function openReviewModal(produkId, trxId) {
    document.getElementById('produk_id').value = produkId;
    if (document.getElementById('transaction_id'))
        document.getElementById('transaction_id').value = trxId;

    document.getElementById('reviewModal').classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    setRating(0);
}

function setRating(rating) {
    currentRating = rating;
    document.getElementById('rating').value = rating;

    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById(`star-${i}`);
        star.classList.toggle('text-yellow-400', i <= rating);
        star.classList.toggle('text-gray-400', i > rating);
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/transactions.blade.php ENDPATH**/ ?>