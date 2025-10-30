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
        </div>


        
        <?php if(request('search')): ?>
            <p class="mb-6 text-gray-600">
                Hasil pencarian untuk:
                <span class="font-semibold">"<?php echo e(request('search')); ?>"</span>
            </p>
        <?php endif; ?>

        <div class="grid gap-8 md:grid-cols-3 lg:grid-cols-4" id="productGrid">
            <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    // use named route if available, otherwise fall back to a safe URL
                    $deskripsiRoute = \Illuminate\Support\Facades\Route::has('user.deskripsi')
                        ? route('user.deskripsi', $item->id)
                        : url('/deskripsi/' . $item->id);
                    $imageSrc = $item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png');
                    $priceNumeric = (int) $item->harga;
                ?>

                <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300"
                     data-price="<?php echo e($priceNumeric); ?>">

                    
                    <a href="<?php echo e($deskripsiRoute); ?>">
                        <img src="<?php echo e($imageSrc); ?>"
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


<script>
    (function(){
        const params = new URLSearchParams(window.location.search);
        const sort = params.get('sort_harga'); // 'asc' or 'desc'
        const min = params.has('price_min') ? parseInt(params.get('price_min')) : null;
        const max = params.has('price_max') ? parseInt(params.get('price_max')) : null;

        const grid = document.getElementById('productGrid');
        if (!grid) return;

        // Collect product nodes
        const items = Array.from(grid.querySelectorAll('.product-card'));

        // Filter by price range if provided
        const filtered = items.filter(el => {
            const price = parseInt(el.dataset.price || 0);
            if (min !== null && !isNaN(min) && price < min) return false;
            if (max !== null && !isNaN(max) && price > max) return false;
            return true;
        });

        // Sort if requested (client-side fallback)
        if (sort === 'asc' || sort === 'desc') {
            filtered.sort((a,b) => {
                const pa = parseInt(a.dataset.price || 0);
                const pb = parseInt(b.dataset.price || 0);
                return sort === 'asc' ? pa - pb : pb - pa;
            });
        }

        // Clear and re-append nodes in order
        grid.innerHTML = '';
        if (filtered.length === 0) {
            grid.innerHTML = '<p class="text-gray-600 col-span-4">Tidak ada buku ditemukan.</p>';
        } else {
            filtered.forEach(n => grid.appendChild(n));
        }
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/user/dashboard.blade.php ENDPATH**/ ?>