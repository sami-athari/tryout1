<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4">Discover Your Next <span class="text-blue-600">Favorite</span></h1>
        <p class="text-gray-600">Explore our curated collection of amazing products</p>
    </div>

    <section id="products">
        <h2 class="text-2xl font-bold mb-6">Featured Products</h2>

        <?php if(request('search')): ?>
            <div class="mb-6">
                <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">
                    Results for "<?php echo e(request('search')); ?>"
                </span>
            </div>
        <?php endif; ?>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php
                $userWishlist = Auth::check()
                    ? \App\Models\Wishlist::where('user_id', Auth::id())->pluck('produk_id')->toArray()
                    : [];
            ?>

            <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    if (\Illuminate\Support\Facades\Route::has('user.produk.show')) {
                        $deskripsiRoute = route('user.produk.show', $item->id);
                    } elseif (\Illuminate\Support\Facades\Route::has('user.deskripsi')) {
                        $deskripsiRoute = route('user.deskripsi', $item->id);
                    } else {
                        $deskripsiRoute = url('/deskripsi/' . $item->id);
                    }

                    $imageSrc = $item->foto ? asset('storage/' . $item->foto) : asset('images/placeholder.png');
                    $priceNumeric = (int) $item->harga;
                    $sold = (int) ($item->transaction_count ?? 0);

                    if ($sold >= 1000000) {
                        $soldLabel = number_format($sold / 1000000, 1) . 'M';
                    } elseif ($sold >= 1000) {
                        $soldLabel = number_format($sold / 1000, 1) . 'k';
                    } else {
                        $soldLabel = (string) $sold;
                    }

                    $rating = number_format($item->average_rating ?? ($item->reviews->avg('rating') ?? 0), 1);
                ?>

                <div class="product-card" data-price="<?php echo e($priceNumeric); ?>">
                    <div class="relative bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                        <button type="button"
                            class="wishlist-btn absolute top-4 right-4 z-10 w-10 h-10 bg-white dark:bg-gray-800 dark:border dark:border-gray-600 rounded-full flex items-center justify-center shadow hover:shadow-lg"
                            data-id="<?php echo e($item->id); ?>"
                            data-liked="<?php echo e(in_array($item->id, $userWishlist) ? 'true' : 'false'); ?>">
                            <?php if(in_array($item->id, $userWishlist)): ?>
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21s-7.5-4.35-10-7.1C-1.2 9.6 3.2 4 8.9 7.1 12 9 12 9 12 9s0 0 3.1-1.9C20.8 4 25.2 9.6 22 13.9 19.5 16.65 12 21 12 21z"/>
                                </svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20.8 8.6c-.9-2-3-3.3-5.3-3.3-1.5 0-2.9.6-3.9 1.6L12 6.8l-.6-.6C9.9 5 8.5 4.4 7 4.4 4.7 4.4 2.6 5.6 1.7 7.6c-1 2.3-.2 5 1.9 7.1L12 21l8.4-6.3c2.1-2.1 2.9-4.8 1.9-7.1z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <?php endif; ?>
                        </button>

                        <a href="<?php echo e($deskripsiRoute); ?>">
                            <img src="<?php echo e($imageSrc); ?>"
                                 alt="<?php echo e($item->nama); ?>"
                                 class="w-full h-48 object-cover">

                            <div class="p-4">
                                <h3 class="font-semibold mb-2 line-clamp-2 dark:text-white"><?php echo e($item->nama); ?></h3>

                                <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                                    Rp <?php echo e(number_format($item->harga ?? 0, 0, ',', '.')); ?>

                                </p>

                                <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-400">★</span>
                                        <span class="font-medium text-gray-700 dark:text-gray-300"><?php echo e($rating); ?></span>
                                    </div>
                                    <span>•</span>
                                    <span><?php echo e($soldLabel); ?> sold</span>
                                </div>
                            </div>
                        </a>

                        <div class="p-4 pt-0">
                            <?php if($item->stok > 0): ?>
                                <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="flex items-center gap-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex items-center border dark:border-gray-600 rounded-lg overflow-hidden">
                                        <button type="button" class="qty-minus px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white">−</button>
                                        <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                               class="qty-input w-12 text-center border-0 dark:bg-gray-800 dark:text-white">
                                        <button type="button" class="qty-plus px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white">+</button>
                                    </div>
                                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                                        Add to Cart
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="text-center py-2 bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-300 rounded-lg">
                                    Out of Stock
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 dark:text-gray-400">No products found</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if($produk->lastPage() > 1): ?>
        <div class="mt-8">
            <nav class="flex justify-center">
                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg px-4 py-2">
                    <?php if($produk->onFirstPage()): ?>
                        <span class="px-3 py-2 text-gray-300">←</span>
                    <?php else: ?>
                        <a href="<?php echo e($produk->previousPageUrl()); ?>" class="px-3 py-2 text-blue-600 hover:bg-blue-50 rounded">←</a>
                    <?php endif; ?>

                    <?php
                        $current = $produk->currentPage();
                        $last = $produk->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);
                    ?>

                    <?php if($start > 1): ?>
                        <a href="<?php echo e($produk->url(1)); ?>" class="px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">1</a>
                        <?php if($start > 2): ?>
                            <span class="px-2 text-gray-400">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for($i = $start; $i <= $end; $i++): ?>
                        <?php if($i == $current): ?>
                            <span class="px-3 py-2 bg-blue-600 text-white rounded font-semibold"><?php echo e($i); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($produk->url($i)); ?>" class="px-3 py-2 text-gray-700 hover:bg-gray-50 rounded"><?php echo e($i); ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($end < $last): ?>
                        <?php if($end < $last - 1): ?>
                            <span class="px-2 text-gray-400">...</span>
                        <?php endif; ?>
                        <a href="<?php echo e($produk->url($last)); ?>" class="px-3 py-2 text-gray-700 hover:bg-gray-50 rounded"><?php echo e($last); ?></a>
                    <?php endif; ?>

                    <?php if($produk->hasMorePages()): ?>
                        <a href="<?php echo e($produk->nextPageUrl()); ?>" class="px-3 py-2 text-blue-600 hover:bg-blue-50 rounded">→</a>
                    <?php else: ?>
                        <span class="px-3 py-2 text-gray-300">→</span>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    <?php endif; ?>

    <footer class="text-center py-6 mt-12 border-t">
        <p class="text-gray-600">&copy; <?php echo e(date('Y')); ?> Seilmu. All rights reserved.</p>
    </footer>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty-input {
    -moz-appearance: textfield;
    appearance: textfield;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.product-card').forEach(card => {
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

    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            e.stopPropagation();

            const produkId = this.dataset.id;
            const liked = this.dataset.liked === "true";

            const url = `/user/wishlist/toggle/${produkId}`;
            const method = liked ? "DELETE" : "POST";

            const res = await fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                },
            });

            const data = await res.json();

            if (data.status === 'added') {
                this.dataset.liked = "true";
                this.innerHTML = `
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21s-7.5-4.35-10-7.1C-1.2 9.6 3.2 4 8.9 7.1 12 9 12 9 12 9s0 0 3.1-1.9C20.8 4 25.2 9.6 22 13.9 19.5 16.65 12 21 12 21z"/>
                    </svg>
                `;

                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Added to wishlist',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }

            if (data.status === 'removed') {
                this.dataset.liked = "false";
                this.innerHTML = `
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.8 8.6c-.9-2-3-3.3-5.3-3.3-1.5 0-2.9.6-3.9 1.6L12 6.8l-.6-.6C9.9 5 8.5 4.4 7 4.4 4.7 4.4 2.6 5.6 1.7 7.6c-1 2.3-.2 5 1.9 7.1L12 21l8.4-6.3c2.1-2.1 2.9-4.8 1.9-7.1z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                `;

                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Removed from wishlist',
                        showConfirmButton: false,
                        timer: 1200
                    });
                }
            }
        });
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/dashboard.blade.php ENDPATH**/ ?>