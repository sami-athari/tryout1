<?php $__env->startSection('content'); ?>
<div class="min-h-screen">
    
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Seilmu</h1>
            <p class="text-lg md:text-xl mb-8 text-blue-100">Discover thousands of your favorite books across various interesting categories.</p>
            <a href="#produk" class="inline-block bg-white text-blue-600 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition">
                Start Shopping
            </a>
        </div>
    </section>

    
    <section id="produk" class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Latest Products</h2>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white border rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="<?php echo e(asset('storage/' . $item->foto)); ?>" alt="<?php echo e($item->nama); ?>"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2"><?php echo e($item->nama); ?></h3>
                        <p class="text-sm text-gray-500 mb-2"><?php echo e($item->kategori ? $item->kategori->nama : '-'); ?></p>
                        <p class="text-xl font-bold text-blue-600 mb-4">Rp <?php echo e(number_format($item->harga,0,',','.')); ?></p>

                        <?php if($item->stok > 0): ?>
                            <?php if(auth()->guard()->check()): ?>
                                
                                <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="flex items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                           class="w-16 border rounded px-2 py-1 text-center">
                                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            <?php else: ?>
                                
                                <div class="flex items-center gap-2">
                                    <input type="number" value="1" disabled
                                           class="w-16 border rounded px-2 py-1 text-center bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <button onclick="mustLogin()" class="flex-1 bg-gray-400 text-white py-2 rounded-lg cursor-pointer hover:bg-gray-500 transition">
                                        Add to Cart
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-red-500 font-semibold text-center py-2">Out of Stock</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">No books found</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>


<script>
function mustLogin() {
    Swal.fire({
        title: 'Login Required',
        text: 'Please login to add products to cart.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Login Now',
        cancelButtonText: 'Later',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo e(route('login')); ?>";
        }
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/welcome.blade.php ENDPATH**/ ?>