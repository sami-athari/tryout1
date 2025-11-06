<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="mb-6">
            <a href="<?php echo e(route('user.dashboard')); ?>"
               class="inline-flex items-center text-blue-900 hover:text-blue-700 font-medium transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-8">
                    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 p-8 flex items-center justify-center">
                        <img id="mainImage"
                             src="<?php echo e(asset('storage/' . $produk->foto)); ?>"
                             alt="<?php echo e($produk->nama); ?>"
                             class="w-full h-full object-contain">
                    </div>


                </div>
            </div>

            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    
                    <h1 class="text-3xl font-bold text-blue-900 mb-3"><?php echo e($produk->nama); ?></h1>

                    
                    <?php if($produk->kategori): ?>
                        <div class="mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                Kategori: <?php echo e($produk->kategori->nama); ?>

                            </span>
                        </div>
                    <?php endif; ?>

                    
                    <?php
                        $average = $produk->reviews->avg('rating') ?? 0;
                        $totalReviews = $produk->reviews->count();

                        // compute sold count label from transaction_count (safe integer)
                        $sold = (int) ($produk->transaction_count ?? 0);
                        if ($sold >= 1000000) {
                            $soldLabel = number_format($sold / 1000000, 1) . 'M+';
                        } elseif ($sold >= 1000) {
                            $soldLabel = number_format($sold / 1000, 1) . 'k+';
                        } else {
                            $soldLabel = (string) $sold;
                        }
                    ?>

                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <span class="<?php echo e($i <= round($average) ? 'text-yellow-400' : 'text-gray-300'); ?> text-xl">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">
                            <?php echo e(number_format($average, 1)); ?>/5 dari <?php echo e($totalReviews); ?> ulasan
                        </span>
                    </div>

                    
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-blue-900 mb-2">
                            Rp <?php echo e(number_format($produk->harga, 0, ',', '.')); ?>

                        </div>
                        <p class="text-gray-600 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-600 font-semibold"><?php echo e($produk->transaction_count ?? 0); ?></span>
                            <span class="text-sm"><?php echo e($soldLabel); ?> terjual</span>
                        </p>
                    </div>


                    
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">

                            Deskripsi Produk
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed text-sm">
                                <?php echo e($produk->deskripsi ?? 'Belum ada deskripsi untuk produk ini.'); ?>

                            </p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Ulasan Pembeli
                    </h3>

                    <?php
                        $reviews = $produk->reviews ?? collect();
                    ?>

                    <?php if($reviews->isEmpty()): ?>
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                        </div>
                    <?php else: ?>
                        <div class="bg-blue-50 rounded-lg p-3 mb-4">
                            <p class="text-xs text-gray-600">
                                Menampilkan <span class="font-semibold"><?php echo e($reviews->take(10)->count()); ?></span> dari <span class="font-semibold"><?php echo e($reviews->count()); ?></span> ulasan
                            </p>
                        </div>

                        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                            <?php $__currentLoopData = $reviews->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $rating = (int) ($review->rating ?? 0);
                                    $comment = $review->komentar ?? $review->comment ?? '';
                                    $imageField = $review->gambar ?? $review->image ?? null;

                                    $images = [];
                                    if ($imageField) {
                                        if (is_array($imageField)) {
                                            $images = $imageField;
                                        } else {
                                            $images = array_filter(array_map('trim', explode(',', (string) $imageField)));
                                        }
                                    }

                                    $reviewer = $review->user->name ?? ($review->user_name ?? 'Pengguna');
                                    $time = optional($review->created_at)->diffForHumans() ?? '';
                                ?>

                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex items-start gap-3">
                                        
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                                <?php echo e(strtoupper(substr($reviewer, 0, 1))); ?>

                                            </div>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="font-bold text-gray-900 text-sm"><?php echo e($reviewer); ?></p>
                                                <div class="flex items-center gap-0.5">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <span class="<?php echo e($i <= $rating ? 'text-yellow-400' : 'text-gray-300'); ?> text-sm">★</span>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 mb-2"><?php echo e($time); ?></p>

                                            <p class="text-gray-700 text-sm leading-relaxed mb-2"><?php echo e($comment); ?></p>

                                            <?php if(!empty($images)): ?>
                                                <div class="flex gap-2 flex-wrap">
                                                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $imgPath = trim($img); ?>
                                                        <?php if($imgPath): ?>
                                                            <img src="<?php echo e(asset('storage/' . ltrim($imgPath, '/'))); ?>"
                                                                 class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200 hover:scale-105 transition cursor-pointer"
                                                                 alt="Review image"
                                                                 onclick="openImageModal(this.src)">
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Atur Jumlah Pembelian</h3>

                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                        <div class="text-2xl font-bold <?php echo e($produk->stok > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php if($produk->stok > 0): ?>
                                <?php echo e($produk->stok); ?> <span class="text-sm font-normal text-gray-600">tersedia</span>
                            <?php else: ?>
                                <span class="text-red-600">Habis</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($produk->stok > 0): ?>
                        <form action="<?php echo e(route('user.cart.add', $produk->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Jumlah</label>
                                <div class="flex items-center gap-3">
                                    <button type="button"
                                            onclick="decrementQty()"
                                            class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 font-bold text-lg transition flex items-center justify-center">
                                        −
                                    </button>
                                    <input type="number"
                                           name="jumlah"
                                           id="quantity"
                                           value="1"
                                           min="1"
                                           max="<?php echo e($produk->stok); ?>"
                                           class="flex-1 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-blue-900 focus:ring-2 focus:ring-blue-200 outline-none transition" />
                                    <button type="button"
                                            onclick="incrementQty()"
                                            class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 font-bold text-lg transition flex items-center justify-center">
                                        +
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Maksimal: <?php echo e($produk->stok); ?></p>
                            </div>


                    <?php else: ?>
                        <button type="button"
                                disabled
                                class="w-full bg-gray-300 text-gray-600 py-3 rounded-xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Stok Habis
                        </button>
                    <?php endif; ?>

                            
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-900 to-blue-700 hover:from-blue-800 hover:to-blue-600 text-white py-3 rounded-xl font-bold text-base shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                + Masukkan ke Keranjang
                            </button>
                            
                        </form>






                </div>
            </div>
        </div>
    </div>
</div>


<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" class="max-w-full max-h-screen rounded-lg shadow-2xl">
    </div>
</div>


<script>
    const maxStock = <?php echo e($produk->stok); ?>;
    const productPrice = <?php echo e($produk->harga); ?>;

    function changeImage(url) {
        document.getElementById('mainImage').src = url;
    }

    function updateSubtotal() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const subtotal = quantity * productPrice;
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    function incrementQty() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value) || 1;
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            updateSubtotal();
        }
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value) || 1;
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updateSubtotal();
        }
    }

    // Update subtotal when quantity changes manually
    document.getElementById('quantity')?.addEventListener('change', function() {
        if (this.value > maxStock) this.value = maxStock;
        if (this.value < 1) this.value = 1;
        updateSubtotal();
    });

    function openImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/user/deskripsi.blade.php ENDPATH**/ ?>