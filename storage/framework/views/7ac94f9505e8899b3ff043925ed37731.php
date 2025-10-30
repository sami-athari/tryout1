<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h2>

    <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold text-gray-700">Invoice: #<?php echo e($trx->id); ?></p>
                    <p class="mt-1">
                        <span class="font-medium">Status:</span>
                        <?php if($trx->status === 'pending'): ?>
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        <?php elseif($trx->status === 'dikirim'): ?>
                            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                Dikirim
                            </span>
                        <?php elseif($trx->status === 'selesai'): ?>
                            <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                                Selesai
                            </span>
                        <?php elseif($trx->status === 'dibatalkan'): ?>
                            <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">
                                Dibatalkan
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-full text-sm bg-gray-200 text-gray-700">
                                <?php echo e(ucfirst($trx->status)); ?>

                            </span>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    
                    <?php if($trx->status !== 'pending'): ?>
                        <a href="<?php echo e(route('user.struk', $trx->id)); ?>"
                           class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                            Lihat Struk
                        </a>
                    <?php endif; ?>

                    
                    <?php if($trx->status === 'dikirim'): ?>
                        <form method="POST" action="<?php echo e(route('user.transactions.selesai', $trx->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-500 transition">
                                Terima
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500 text-center">Belum ada transaksi yang tercatat.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/transactions.blade.php ENDPATH**/ ?>