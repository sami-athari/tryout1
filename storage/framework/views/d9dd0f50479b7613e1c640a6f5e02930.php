<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white">

    
    <section class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-black text-white py-64 overflow-hidden">
        <div class="container mx-auto text-center px-6">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fadeInDown">
                Selamat Datang di Seilmu
            </h2>
            <p class="text-lg md:text-xl mb-6 animate-fadeInUp">
                Temukan ribuan buku favoritmu dengan berbagai kategori menarik.
            </p>
            <a href="#produk" class="bg-white text-blue-900 font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-gray-100 transition animate-bounce">
                Mulai Belanja
            </a>
        </div>
    </section>

    
    <section id="produk" class="container mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-blue-900 border-b-2 border-blue-900 inline-block">
                ✨ Produk Terbaru
            </h3>

            \
        </div>

        
        <?php if(request('search')): ?>
            <p class="mb-6 text-gray-600">
                Hasil pencarian untuk:
                <span class="font-semibold">"<?php echo e(request('search')); ?>"</span>
            </p>
        <?php endif; ?>

        <div class="grid gap-8 md:grid-cols-3 lg:grid-cols-4">
            <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                    <img src="<?php echo e(asset('storage/' . $item->foto)); ?>"
                         alt="<?php echo e($item->nama); ?>"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-blue-900"><?php echo e($item->nama); ?></h4>
                        <p class="text-xl font-bold text-blue-900 mt-2">
                            Rp <?php echo e(number_format($item->harga,0,',','.')); ?>

                        </p>

                        <?php if($item->stok > 0): ?>
                            <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="mt-4 flex items-center space-x-2">
                                <?php echo csrf_field(); ?>
                                <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                       class="w-16 border rounded text-center text-black">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                                    + Keranjang
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="mt-4 text-red-500 font-semibold">Stok Habis</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600 col-span-4">Tidak ada buku ditemukan.</p>
            <?php endif; ?>
        </div>
    </section>

    
    <footer class="bg-blue-900 text-white text-center py-6 mt-12">
        <p>&copy; <?php echo e(date('Y')); ?> Seilmu. All rights reserved.</p>
    </footer>
</div>


<style>
@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeInDown {
    animation: fadeInDown 1s ease forwards;
}
.animate-fadeInUp {
    animation: fadeInUp 1s ease forwards;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/user/dashboard.blade.php ENDPATH**/ ?>