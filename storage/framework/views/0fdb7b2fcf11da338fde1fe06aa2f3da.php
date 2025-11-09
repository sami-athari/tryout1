<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-12">

    <h1 class="text-3xl font-extrabold text-blue-900 mb-8 text-center">
        🛒 Keranjang Belanja
    </h1>

    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                icon: 'success',
                timer: 1800,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <?php if($items->count()): ?>

        <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
            <table class="min-w-full">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-center">Foto</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-center">Stok Tersisa</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-item-id="<?php echo e($item->id); ?>"
                            data-stok="<?php echo e($item->produk->stok); ?>"
                            data-harga="<?php echo e($item->produk->harga); ?>">

                            <td class="px-4 py-3 font-medium text-gray-900">
                                <?php echo e($item->produk->nama); ?>

                            </td>

                            <td class="px-4 py-3 text-center">
                                <img src="<?php echo e(asset('storage/' . $item->produk->foto)); ?>"
                                     class="w-16 h-16 object-cover rounded-md mx-auto">
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                <?php echo e($item->produk->kategori->nama ?? '-'); ?>

                            </td>

                            <td class="px-4 py-3 text-right font-semibold text-blue-700">
                                Rp <?php echo e(number_format($item->produk->harga, 0, ',', '.')); ?>

                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button"
                                            class="minus-btn px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                        −
                                    </button>

                                    <span class="qty-text px-3 py-1 border rounded bg-gray-50">
                                        <?php echo e($item->jumlah); ?>

                                    </span>

                                    <button type="button"
                                            class="plus-btn px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                        +
                                    </button>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center stok-text">
                                <?php echo e($item->produk->stok - $item->jumlah); ?>

                            </td>

                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="<?php echo e(route('user.cart.remove', $item->id)); ?>"
                                      class="delete-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="button"
                                            class="delete-btn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div id="total" class="text-xl font-bold text-right mt-6 text-blue-900">
            Total:
            Rp <?php echo e(number_format($items->sum(fn($i) => $i->produk->harga * $i->jumlah), 0, ',', '.')); ?>

        </div>

        
        <div class="mt-6 text-right">
            <a href="<?php echo e(route('user.checkout.form')); ?>"
               class="inline-block px-6 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Checkout Sekarang
            </a>
        </div>

    <?php else: ?>
        <div class="text-center py-16">
            <p class="text-gray-600 text-lg">Keranjangmu masih kosong 😊</p>
            <a href="<?php echo e(route('user.dashboard')); ?>"
               class="mt-4 inline-block px-6 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800">
                Belanja Sekarang
            </a>
        </div>
    <?php endif; ?>

</div>


<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Produk?',
                text: "Produk akan dihapus dari keranjang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('tr[data-item-id]').forEach(row => {
            const qty = parseInt(row.querySelector('.qty-text').textContent);
            const harga = parseInt(row.dataset.harga);
            total += qty * harga;
        });
        document.getElementById('total').textContent = 'Total: Rp ' + total.toLocaleString('id-ID');
    }

    function updateQty(row, delta) {
        const qtySpan = row.querySelector('.qty-text');
        let currentQty = parseInt(qtySpan.textContent);
        const stokAsli = parseInt(row.dataset.stok);

        let newQty = currentQty + delta;
        if(newQty < 1) newQty = 1;
        if(newQty > stokAsli) newQty = stokAsli;

        qtySpan.textContent = newQty;
        row.querySelector('.stok-text').textContent = stokAsli - newQty;

        updateTotal();

        const itemId = row.dataset.itemId;
        fetch('<?php echo e(url("/user/cart")); ?>/' + itemId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ quantity: newQty })
        });
    }

    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            updateQty(this.closest('tr'), -1);
        });
    });

    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            updateQty(this.closest('tr'), 1);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/cart.blade.php ENDPATH**/ ?>