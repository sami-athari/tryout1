<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8 text-center">📝 Checkout</h1>

    <?php if($items->count() > 0): ?>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-blue-900 mb-4">Ringkasan Pesanan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Produk</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $total = 0; ?>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $subtotal = $item->jumlah * $item->produk->harga;
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800"><?php echo e($item->produk->nama); ?></td>
                                <td class="px-4 py-3 text-center"><?php echo e($item->jumlah); ?></td>
                                <td class="px-4 py-3 text-right text-blue-800 font-semibold">Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-gray-100">
                            <td colspan="2" class="px-4 py-3 text-right font-bold">Total Harga</td>
                            <td class="px-4 py-3 text-right font-bold text-blue-900">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <form method="POST" action="<?php echo e(route('user.checkout.process')); ?>" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <?php echo csrf_field(); ?>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                <textarea name="alamat" rows="3" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"><?php echo e(old('alamat')); ?></textarea>
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="telepon" required pattern="[0-9]{10,13}" minlength="10" maxlength="13"
                    value="<?php echo e(old('telepon')); ?>"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select name="metode_pembayaran" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="OVO">OVO</option>
                    <option value="Dana">Dana</option>
                    <option value="Gopay">Gopay</option>
                </select>
            </div>

            
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="text-gray-700 mb-1">💳 Silakan transfer ke nomor berikut:</p>
                <p class="font-semibold text-blue-900">+62-851-5959-2448</p>
                <p class="text-gray-600">Atas nama: <span class="font-medium">Admin Toko Buku</span></p>
            </div>

            
            <input type="hidden" name="total_harga" value="<?php echo e($total); ?>">

            <button type="submit"
                class="w-full py-3 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition">
                ✅ Konfirmasi dan Proses Pesanan
            </button>
        </form>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">Keranjang kosong. Silakan tambahkan produk terlebih dahulu 🛍</p>
            <a href="<?php echo e(route('user.dashboard')); ?>"
               class="mt-4 inline-block px-5 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Belanja Sekarang
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/checkout.blade.php ENDPATH**/ ?>