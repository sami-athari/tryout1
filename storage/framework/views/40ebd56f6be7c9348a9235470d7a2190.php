<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white dark:bg-[#0f172a] py-12 px-6 transition-all">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-200 mb-6">💖 Wishlist Kamu</h2>

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php elseif(session('info')): ?>
            <div class="bg-blue-100 dark:bg-blue-800 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-200 px-4 py-3 rounded mb-4">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        
        <?php if($wishlist->isEmpty()): ?>
            <p class="text-gray-600 dark:text-gray-300 text-center mt-10">
                Kamu belum menambahkan produk ke wishlist 💭
            </p>
        <?php else: ?>

            
            <div class="grid gap-6 sm:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <?php $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $produk = $item->produk;
                        $deskripsiRoute = route('user.produk.show', $produk->id);
                        $imageSrc = $produk->foto ? asset('storage/' . $produk->foto) : asset('images/placeholder.png');
                    ?>

                    
                    <div class="relative bg-white dark:bg-[#1e293b] rounded-2xl shadow-md overflow-hidden
                                transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-transparent dark:border-[#334155]">

                        <a href="<?php echo e($deskripsiRoute); ?>">
                            <div class="relative overflow-hidden">
                                <img src="<?php echo e($imageSrc); ?>"
                                     alt="<?php echo e($produk->nama); ?>"
                                     class="w-full aspect-[4/3] object-cover rounded-t-xl transition-transform duration-300 hover:scale-105">
                            </div>

                            <div class="p-4">
                                <h4 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-200 line-clamp-2">
                                    <?php echo e($produk->nama); ?>

                                </h4>
                            </div>
                        </a>

                        <div class="px-4 pb-4">
                            <p class="text-lg sm:text-xl font-bold text-blue-900 dark:text-blue-300 mt-2">
                                Rp <?php echo e(number_format($produk->harga,0,',','.')); ?>

                            </p>

                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                                Kategori: <?php echo e($produk->kategori ? $produk->kategori->nama : '-'); ?>

                            </p>

                            <div class="flex justify-between items-center">
                                
                                <form action="<?php echo e(route('user.cart.add', $produk->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit"
                                            class="bg-blue-900 dark:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 dark:hover:bg-blue-600 transition">
                                        + Keranjang
                                    </button>
                                </form>

                                
                                <form action="<?php echo e(route('user.wishlist.remove', $item->id)); ?>" method="POST"
                                      onsubmit="return confirm('Hapus produk ini dari wishlist?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-semibold text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        <?php endif; ?>
    </div>
</div>


<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Dark Mode Transition Smooth */
.dark\:bg-transition {
    transition: background-color 0.3s ease, color 0.3s ease;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/wishlist.blade.php ENDPATH**/ ?>