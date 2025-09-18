<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="p-8 max-w-7xl mx-auto">

    
    <div class="mb-8 rounded-2xl shadow-xl p-6 bg-gradient-to-r from-blue-900 to-blue-600 text-white">
        <h2 class="text-3xl font-extrabold mb-2">📚 Daftar Produk Bookstore</h2>
        <p class="text-blue-100">
            Kelola semua koleksi buku dengan mudah. Tambahkan, perbarui, atau hapus produk sesuai kebutuhan.
        </p>
    </div>

    
    <div class="flex justify-between items-center mb-6">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="px-5 py-2 rounded-xl font-semibold shadow-md bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition">
            ← Kembali ke Dashboard
        </a>

        <a href="<?php echo e(route('admin.produk.create')); ?>"
           class="px-5 py-2 rounded-xl font-semibold shadow-md bg-blue-600 text-white hover:bg-blue-700 transition">
            + Tambah Produk
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "<?php echo e(session('success')); ?>",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?php echo e(session("error")); ?>',
                confirmButtonColor: '#2563eb'
            });
        </script>
    <?php endif; ?>

    
    <div class="overflow-hidden rounded-2xl shadow-xl bg-white">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gradient-to-r from-blue-800 to-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-center">Gambar</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-4 py-3 font-bold text-gray-700"><?php echo e($index + 1); ?></td>
                        <td class="px-4 py-3 font-semibold text-blue-800"><?php echo e($produk->nama); ?></td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                <?php echo e($produk->kategori->nama ?? '-'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 font-bold text-green-600">
                            Rp <?php echo e(number_format($produk->harga, 0, ',', '.')); ?>

                        </td>
                        <td class="px-4 py-3"><?php echo e($produk->stok); ?></td>
                        <td class="px-4 py-3 text-center">
                            <?php if($produk->foto): ?>
                                <img src="<?php echo e(asset('storage/' . $produk->foto)); ?>"
                                     alt="<?php echo e($produk->nama); ?>"
                                     class="h-20 w-20 object-cover rounded-lg shadow-md mx-auto border">
                            <?php else: ?>
                                <span class="italic text-gray-400">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="<?php echo e(route('admin.produk.edit', $produk->id)); ?>"
                               class="px-3 py-1 rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm text-sm">
                                ✏️ Edit
                            </a>
                            <form id="delete-form-<?php echo e($produk->id); ?>"
                                  action="<?php echo e(route('admin.produk.destroy', $produk->id)); ?>"
                                  method="POST" class="inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button"
                                        onclick="confirmDelete('<?php echo e($produk->id); ?>', '<?php echo e($produk->stok); ?>', '<?php echo e($produk->orders_count); ?>')"
                                        class="px-3 py-1 rounded-lg text-white bg-red-600 hover:bg-red-700 shadow-sm text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 italic">
                            Belum ada produk ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    function confirmDelete(id, stok, ordersCount) {
        if (stok > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Dihapus!',
                text: 'Produk masih memiliki stok. Harap habiskan stok terlebih dahulu.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        if (ordersCount > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Dihapus!',
                text: 'Produk ini masih ada dalam pesanan. Tidak bisa dihapus.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data produk akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#2563eb',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/produk/index.blade.php ENDPATH**/ ?>