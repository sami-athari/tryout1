<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white dark-mode-bg">

    
    <section class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-black text-white py-24 md:py-32 lg:py-40 overflow-hidden">
        <div class="container mx-auto text-center px-6 relative z-10">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Selamat Datang di <span class="text-blue-300">Seilmu</span>
            </h2>
            <p class="text-base sm:text-lg md:text-xl mb-8 max-w-2xl mx-auto text-gray-100">
                Temukan ribuan buku favoritmu dengan berbagai kategori menarik. Semua bisa kamu jelajahi dengan mudah dan cepat.
            </p>
            <a href="#produk" class="inline-block bg-white text-blue-900 font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:scale-105">
               Mulai Belanja
            </a>
        </div>
        <div class="absolute inset-0 opacity-5 bg-cover bg-center" style="background-image: url('/images/book-pattern.svg');"></div>
    </section>

    
    <section id="produk" class="container mx-auto px-4 sm:px-6 py-12">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-4">
            <h3 class="text-2xl font-bold text-blue-900 dark-mode-title border-b-4 border-blue-900 inline-block pb-1">
                ✨ Produk Terbaru
            </h3>
        </div>

        <?php if(request('search')): ?>
            <p class="mb-6 text-gray-600 dark-mode-text">
                Hasil pencarian untuk: <span class="font-semibold text-gray-800 dark-mode-text-bold">"<?php echo e(request('search')); ?>"</span>
            </p>
        <?php endif; ?>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" id="productGrid">
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
                        $soldLabel = number_format($sold / 1000000, 1) . 'M+';
                    } elseif ($sold >= 1000) {
                        $soldLabel = number_format($sold / 1000, 1) . 'k+';
                    } else {
                        $soldLabel = (string) $sold;
                    }

                    $rating = number_format($item->average_rating ?? ($item->reviews->avg('rating') ?? 0), 1);
                ?>

                <div class="relative product-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group"
                     data-price="<?php echo e($priceNumeric); ?>">

                    
                    <div class="absolute top-3 right-3 z-10">
                        <button type="button"
                                class="add-wishlist-local wishlist-btn inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/90 hover:bg-white shadow-md transition group-hover:scale-110"
                                data-id="<?php echo e($item->id); ?>">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.8 8.6c-.9-2-3-3.3-5.3-3.3-1.5 0-2.9.6-3.9 1.6L12 6.8l-.6-.6C9.9 5 8.5 4.4 7 4.4 4.7 4.4 2.6 5.6 1.7 7.6c-1 2.3-.2 5 1.9 7.1L12 21l8.4-6.3c2.1-2.1 2.9-4.8 1.9-7.1z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <a href="<?php echo e($deskripsiRoute); ?>" class="block">
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="<?php echo e($imageSrc); ?>" alt="<?php echo e($item->nama); ?>"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <div class="p-4">
                            <h4 class="product-title text-lg font-semibold text-gray-800 line-clamp-2 mb-2 group-hover:text-blue-900 transition">
                                <?php echo e($item->nama); ?>

                            </h4>
                            <p class="product-price text-xl font-bold text-blue-900 mb-2">
                                Rp <?php echo e(number_format($item->harga ?? 0, 0, ',', '.')); ?>

                            </p>
                            <div class="flex items-center text-sm text-gray-600 product-meta gap-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 .587l3.668 7.568L24 9.423l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.27 0 9.423l8.332-1.268z"/>
                                    </svg>
                                    <span class="font-medium"><?php echo e($rating); ?></span>
                                </div>
                                <span class="text-gray-400">•</span>
                                <span><?php echo e($soldLabel); ?> terjual</span>
                            </div>
                        </div>
                    </a>

                    <div class="px-4 pb-4">
                        <?php if($item->stok > 0): ?>
                            <form action="<?php echo e(route('user.cart.add', $item->id)); ?>" method="POST" class="flex items-center gap-2">
                                <?php echo csrf_field(); ?>
                                <input type="number" name="jumlah" value="1" min="1" max="<?php echo e($item->stok); ?>"
                                       class="product-qty-input w-16 border border-gray-300 rounded-lg text-center text-black py-2 focus:ring-2 focus:ring-blue-400">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition font-medium">
                                    + Keranjang
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="text-red-500 font-semibold text-center py-2">Stok Habis</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 dark-mode-text text-lg">Tidak ada buku ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php if($produk->lastPage() > 1): ?>
        <div class="mt-10 pb-12 flex justify-center">
            <nav class="pagination-nav flex flex-wrap items-center justify-center gap-2 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-xl shadow-lg">
                <?php if($produk->onFirstPage()): ?>
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed">‹</span>
                <?php else: ?>
                    <a href="<?php echo e($produk->previousPageUrl()); ?>"
                       class="pagination-link px-3 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">‹</a>
                <?php endif; ?>

                <?php
                    $current = $produk->currentPage();
                    $last = $produk->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                ?>

                <?php if($start > 1): ?>
                    <a href="<?php echo e($produk->url(1)); ?>" class="pagination-link px-3 py-2 text-blue-900 hover:bg-blue-50 rounded-lg transition">1</a>
                    <?php if($start > 2): ?>
                        <span class="text-gray-400 dark-mode-text">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $current): ?>
                        <span class="pagination-active px-3 py-2 bg-blue-900 text-white rounded-lg font-semibold shadow-md"><?php echo e($i); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($produk->url($i)); ?>" class="pagination-link px-3 py-2 text-blue-900 hover:bg-blue-50 rounded-lg transition"><?php echo e($i); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if($end < $last): ?>
                    <?php if($end < $last - 1): ?>
                        <span class="text-gray-400 dark-mode-text">...</span>
                    <?php endif; ?>
                    <a href="<?php echo e($produk->url($last)); ?>" class="pagination-link px-3 py-2 text-blue-900 hover:bg-blue-50 rounded-lg transition"><?php echo e($last); ?></a>
                <?php endif; ?>

                <?php if($produk->hasMorePages()): ?>
                    <a href="<?php echo e($produk->nextPageUrl()); ?>"
                       class="pagination-link px-3 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">›</a>
                <?php else: ?>
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed">›</span>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>

    <footer class="footer-section bg-blue-900 text-white text-center py-6 mt-12">
        <p>&copy; <?php echo e(date('Y')); ?> Seilmu. All rights reserved.</p>
    </footer>
</div>

<style>
/* Dark mode specific overrides for dashboard */
.dark-mode .dark-mode-bg {
    background-color: #0f172a !important;
}

.dark-mode .dark-mode-title {
    color: #60a5fa !important;
    border-color: #60a5fa !important;
}

.dark-mode .dark-mode-text {
    color: #cbd5e1 !important;
}

.dark-mode .dark-mode-text-bold {
    color: #e2e8f0 !important;
}

.dark-mode .product-card {
    background-color: #1e293b !important;
    border: 1px solid #334155;
}

.dark-mode .product-card:hover {
    border-color: #475569;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
}

.dark-mode .product-title {
    color: #e2e8f0 !important;
}

.dark-mode .product-card:hover .product-title {
    color: #60a5fa !important;
}

.dark-mode .product-price {
    color: #60a5fa !important;
}

.dark-mode .product-meta {
    color: #94a3b8 !important;
}

.dark-mode .product-qty-input {
    background-color: #1e293b !important;
    color: #e2e8f0 !important;
    border-color: #475569 !important;
}

.dark-mode .wishlist-btn {
    background-color: rgba(30, 41, 59, 0.9) !important;
}

.dark-mode .wishlist-btn:hover {
    background-color: rgba(30, 41, 59, 1) !important;
}

.dark-mode .wishlist-btn svg {
    color: #cbd5e1 !important;
}

.dark-mode .wishlist-btn:hover svg {
    color: #ef4444 !important;
}

.dark-mode .pagination-nav {
    background-color: rgba(30, 41, 59, 0.8) !important;
    backdrop-filter: blur(10px);
}

.dark-mode .pagination-link {
    color: #60a5fa !important;
}

.dark-mode .pagination-link:hover {
    background-color: #334155 !important;
}

.dark-mode .pagination-active {
    background-color: #1e40af !important;
}

.dark-mode .footer-section {
    background-color: #1e293b !important;
}

/* Hero section dark mode */
.dark-mode section.bg-gradient-to-r {
    background: linear-gradient(to right, #1e3a8a, #1e293b, #000) !important;
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

                    // Update button appearance
                    this.innerHTML = '<svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7.5-4.35-10-7.1C-1.2 9.6 3.2 4 8.9 7.1 12 9 12 9 12 9s0 0 3.1-1.9C20.8 4 25.2 9.6 22 13.9 19.5 16.65 12 21 12 21z"/></svg>';

                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: '❤️ Ditambahkan ke wishlist',
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
                            title: 'Sudah ada di wishlist',
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

    // Smooth scroll to products
    document.querySelectorAll('a[href="#produk"]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('produk')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/user/dashboard.blade.php ENDPATH**/ ?>