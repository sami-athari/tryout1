<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd, #7dd3fc);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
        }
        .badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
        .badge-pending {
            @apply bg-yellow-400 text-black;
        }
        .badge-dikirim {
            @apply bg-blue-400 text-white;
        }
        .badge-selesai {
            @apply bg-green-500 text-white;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-12 px-6">
    
    <h2 class="text-3xl font-extrabold text-center mb-8 text-gray-900">
        📋 Daftar Transaksi Pengguna
    </h2>

    <?php if($transactions->isEmpty()): ?>
        <div class="p-6 text-center rounded-xl bg-yellow-100 text-yellow-800 font-medium shadow-md">
            🚫 Belum ada transaksi masuk saat ini.
        </div>
    <?php else: ?>
        <div class="overflow-x-auto shadow-2xl glass">
            <table class="min-w-full text-sm">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white uppercase text-xs tracking-wider">
                    <tr class="text-center">
                        <th class="py-4 px-6">#Invoice</th>
                        <th class="py-4 px-6 text-left">Pengguna</th>
                        <th class="py-4 px-6">Telepon</th>
                        <th class="py-4 px-6">Alamat</th>
                        <th class="py-4 px-6 text-left">Produk</th>
                        <th class="py-4 px-6">Metode Bayar</th>
                        <th class="py-4 px-6">Total</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $total = 0; ?>
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="py-4 px-6 font-bold text-center text-gray-700">
                                #<?php echo e($trx->id); ?>

                            </td>
                            <td class="py-4 px-6 text-gray-900"><?php echo e($trx->user->name); ?></td>
                            <td class="py-4 px-6 text-center text-gray-700"><?php echo e($trx->telepon); ?></td>
                            <td class="py-4 px-6 text-gray-600"><?php echo e($trx->alamat); ?></td>
                            <td class="py-4 px-6">
                                <ul class="space-y-2">
                                    <?php $__currentLoopData = $trx->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $subtotal = $item->harga * $item->jumlah;
                                            $total += $subtotal;
                                        ?>
                                        <li class="bg-gray-100 rounded-md px-3 py-2">
                                            🛒 <span class="font-semibold"><?php echo e($item->produk->nama); ?></span>
                                            x <?php echo e($item->jumlah); ?>

                                            <div class="text-sm text-gray-500">
                                                Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?>

                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </td>
                            <td class="py-4 px-6 text-center capitalize text-gray-800">
                                <?php echo e($trx->metode_pembayaran); ?>

                            </td>
                            <td class="py-4 px-6 font-bold text-green-600 text-center">
                                Rp <?php echo e(number_format($total, 0, ',', '.')); ?>

                            </td>
                            <td class="py-4 px-6 text-center">
    <span class="
        px-3 py-1 rounded-full text-sm font-semibold
        <?php if($trx->status === 'pending'): ?> bg-yellow-100 text-yellow-800
        <?php elseif($trx->status === 'dikirim'): ?> bg-blue-100 text-blue-800
        <?php elseif($trx->status === 'selesai'): ?> bg-green-100 text-green-800
        <?php endif; ?>
    ">
        <?php echo e(ucfirst($trx->status)); ?>

    </span>
</td>

                            <td class="py-4 px-6 text-center">
                                <?php if($trx->status === 'pending'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.transactions.konfirmasi', $trx->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm shadow-md transition">
                                            ✅ Konfirmasi
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-400 italic">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>