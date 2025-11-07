<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">

    
    <section class="relative overflow-hidden pt-20 pb-32">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700 opacity-5"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto animate-fade-in-up">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 tracking-tight">
                    Discover Your Next
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                        Favorite
                    </span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Explore our curated collection of amazing products. Simple, fast, and delightful shopping experience.
                </p>
                <a href="#products" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-full font-medium hover:bg-blue-700 transition-all transform hover:scale-105 hover:shadow-xl">
                    Start Shopping
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </section>

    
    <section id="products" class="container mx-auto px-6 py-16">
        <div class="flex justify-between items-center mb-12">
            <div class="animate-fade-in-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Featured Products</h2>
                <div class="h-1 w-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full"></div>
            </div>
        </div>

        <?php if(request('search')): ?>
            <div class="mb-8 animate-fade-in">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="font-medium">Results for "<?php echo e(request('search')); ?>"</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
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

                <div class="product-card group" data-price="<?php echo e($priceNumeric); ?>">
                    <div class="relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">

                        
                        <button type="button"
                                class="add-wishlist-local absolute top-4 right-4 z-10 w-11 h-11 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all hover:scale-110"
                                data-id="<?php echo e($item->id); ?>">
                            <svg class="w-5 h-5 text-gray-700 hover:text-red-500 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.8 8.6c-.9-2-3-3.3-5.3-3.3-1.5 0-2.9.6-3.9 1.6L12 6.8l-.6-.6C9.9 5 8.5 4.4 7 4.4 4.7 4.4 2.6 5.6 1.7 7.6c-1 2.3-.2 5 1.9 7.1L12 21l8.4-6.3c2.1-2.1 2.9-4.8 1.9-7.1z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <a href="<?php echo e($deskripsiRoute); ?>" class="block">
                            <div class="relative overflow-hidden aspect-[4/3] bg-gray-100">
                                <img src="<?php echo e($imageSrc); ?>"
                                     alt="<?php echo e($item->nama); ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <?php echo e($item->nama); ?>

                                </h3>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-gray-900">
                                        Rp <?php echo e(number_format($item->harga ?? 0, 0, ',', '.')); ?>

                                    </span>
                                </div>

                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span class="font-medium text-gray-700"><?php echo e($rating); ?></span>
                                    </div>
                                    <span class="text-gray-400">•</span>
                                    <span class="font-medium"><?php echo e($soldLabel); ?> sold</span>
                                </div>
                            </div>
                        </a>

                        <div class="px-6 pb-6">
                            <?php if($item->stok > 0): ?>
                                <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="flex items-center gap-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex items-center border border-gray-200 rounded-full overflow-hidden">
                                        <button type="button" class="qty-minus px-3 py-2 hover:bg-gray-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                               class="qty-input w-12 text-center border-0 text-gray-900 font-medium focus:ring-0">
                                        <button type="button" class="qty-plus px-3 py-2 hover:bg-gray-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-full font-medium hover:shadow-lg transition-all transform hover:scale-105">
                                        Add to Cart
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="text-center py-3 bg-red-50 text-red-600 font-medium rounded-full">
                                    Out of Stock
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg">No products found</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php if($produk->lastPage() > 1): ?>
        <div class="container mx-auto px-6 pb-16">
            <nav class="flex justify-center">
                <div class="flex items-center gap-2 bg-white rounded-full shadow-lg px-4 py-2">
                    <?php if($produk->onFirstPage()): ?>
                        <span class="px-4 py-2 text-gray-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($produk->previousPageUrl()); ?>" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-full transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php
                        $current = $produk->currentPage();
                        $last = $produk->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);
                    ?>

                    <?php if($start > 1): ?>
                        <a href="<?php echo e($produk->url(1)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium">1</a>
                        <?php if($start > 2): ?>
                            <span class="px-2 text-gray-400">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for($i = $start; $i <= $end; $i++): ?>
                        <?php if($i == $current): ?>
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full font-semibold shadow-md"><?php echo e($i); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($produk->url($i)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium"><?php echo e($i); ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($end < $last): ?>
                        <?php if($end < $last - 1): ?>
                            <span class="px-2 text-gray-400">...</span>
                        <?php endif; ?>
                        <a href="<?php echo e($produk->url($last)); ?>" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-full transition font-medium"><?php echo e($last); ?></a>
                    <?php endif; ?>

                    <?php if($produk->hasMorePages()): ?>
                        <a href="<?php echo e($produk->nextPageUrl()); ?>" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-full transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    <?php else: ?>
                        <span class="px-4 py-2 text-gray-300 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    <?php endif; ?>

    <footer class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-center py-8 mt-20">
        <p class="text-blue-100">&copy; <?php echo e(date('Y')); ?> Seilmu. All rights reserved.</p>
    </footer>
</div>

<style>
/* Animations */
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-left {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}

.animate-fade-in-left {
    animation: fade-in-left 0.8s ease-out;
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Product Card Enhancements */
.product-card {
    animation: fade-in 0.6s ease-out;
}

/* Quantity Input Styling */
.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.qty-input {
    -moz-appearance: textfield;
}

/* Dark mode overrides */
.dark-mode {
    background: linear-gradient(to bottom right, #0f172a, #1e293b, #0f172a) !important;
}

.dark-mode .bg-gradient-to-br {
    background: linear-gradient(to bottom right, #1e293b, #0f172a, #1e3a8a) !important;
}

.dark-mode .product-card > div {
    background-color: #1e293b !important;
    border: 1px solid #334155;
}

.dark-mode .product-card h3 {
    color: #e2e8f0 !important;
}

.dark-mode .product-card h3:hover {
    color: #60a5fa !important;
}

.dark-mode .product-card .text-gray-900 {
    color: #e2e8f0 !important;
}

.dark-mode .product-card .text-gray-700 {
    color: #cbd5e1 !important;
}

.dark-mode .product-card .text-gray-500 {
    color: #94a3b8 !important;
}

.dark-mode .product-card .border-gray-200 {
    border-color: #334155 !important;
}

.dark-mode .product-card .bg-white\/90 {
    background-color: rgba(30, 41, 59, 0.9) !important;
}

.dark-mode .product-card .hover\:bg-gray-50:hover {
    background-color: #334155 !important;
}

.dark-mode .qty-input {
    background-color: #1e293b !important;
    color: #e2e8f0 !important;
}

.dark-mode nav > div {
    background-color: #1e293b !important;
}

.dark-mode nav .text-gray-700 {
    color: #cbd5e1 !important;
}

.dark-mode nav .hover\:bg-blue-50:hover {
    background-color: #334155 !important;
}

.dark-mode footer {
    background: linear-gradient(to right, #1e3a8a, #1e293b) !important;
}

.dark-mode h1,
.dark-mode h2 {
    color: #e2e8f0 !important;
}

.dark-mode .text-gray-600 {
    color: #94a3b8 !important;
}

.dark-mode .bg-blue-50 {
    background-color: rgba(59, 130, 246, 0.1) !important;
}

.dark-mode .text-blue-700 {
    color: #60a5fa !important;
}

.dark-mode .bg-gray-100 {
    background-color: #334155 !important;
}

.dark-mode .text-gray-400 {
    color: #64748b !important;
}

.dark-mode .text-gray-500 {
    color: #94a3b8 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Wishlist functionality
    document.querySelectorAll('.add-wishlist-local').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.id;
            if (!id) return;

            try {
                const key = 'seilmu_wishlist';
                const raw = localStorage.getItem(key);
                let list = raw ? JSON.parse(raw) : [];

                if (!list.find(i => String(i.id) === String(id))) {
                    list.push({ id: id, added_at: new Date().toISOString() });
                    localStorage.setItem(key, JSON.stringify(list));

                    this.innerHTML = '<svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7.5-4.35-10-7.1C-1.2 9.6 3.2 4 8.9 7.1 12 9 12 9 12 9s0 0 3.1-1.9C20.8 4 25.2 9.6 22 13.9 19.5 16.65 12 21 12 21z"/></svg>';

                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Added to wishlist',
                            showConfirmButton: false,
                            timer: 1500,
                            background: document.body.classList.contains('dark-mode') ? '#1e293b' : '#fff',
                            color: document.body.classList.contains('dark-mode') ? '#e2e8f0' : '#000'
                        });
                    }
                } else {
                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Already in wishlist',
                            showConfirmButton: false,
                            timer: 1200,
                            background: document.body.classList.contains('dark-mode') ? '#1e293b' : '#fff',
                            color: document.body.classList.contains('dark-mode') ? '#e2e8f0' : '#000'
                        });
                    }
                }
            } catch (err) {
                console.error('Wishlist error:', err);
            }
        });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Quantity controls
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
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/user/dashboard.blade.php ENDPATH**/ ?>