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
        /* pagination pills */
        .page-pill { padding: .45rem .65rem; border-radius: .5rem; min-width: 36px; text-align:center; }
        .page-pill.active { background: #1d4ed8; color: white; font-weight: 700; box-shadow: 0 6px 18px rgba(99,102,241,0.12); }
        .page-pill.disabled { opacity: .5; cursor: not-allowed; }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        // jika butuh kategori di view, ambil langsung (tidak menambah variable dari controller)
        $kategori = \App\Models\Kategori::all();
    ?>

    <div class="p-8 max-w-7xl mx-auto">
        
        <div class="mb-6 rounded-2xl p-6 bg-gradient-to-r from-blue-900 to-blue-600 text-white shadow-lg">
            <h2 class="text-2xl font-extrabold">📚 Daftar Produk Buku Seilmu</h2>
            <p class="text-blue-100 mt-1">Kelola koleksi buku — tambah, edit, hapus, atau cari produk dengan cepat.</p>
        </div>

        
        <form action="<?php echo e(route('admin.produk.index')); ?>" method="GET" class="glass rounded-2xl p-4 mb-6 flex flex-col md:flex-row md:items-center gap-3">
            <div class="w-full md:w-1/4">
                <select name="kategori" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k->id); ?>" <?php echo e((int) request()->input('kategori') === $k->id ? 'selected' : ''); ?>>
                            <?php echo e($k->nama); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex gap-2 w-full">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari produk..."
                       class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">Cari</button>
            </div>
        </form>

        
        <div class="flex justify-between items-center mb-4">
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="px-4 py-2 rounded-lg font-semibold bg-yellow-400 text-blue-900 shadow">← Dashboard</a>
            <a href="<?php echo e(route('admin.produk.create')); ?>"
               class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow">+ Tambah Produk</a>
        </div>

        
        <?php if(session('success')): ?>
            <div class="mb-4 p-3 rounded bg-green-50 text-green-800"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-4 p-3 rounded bg-red-50 text-red-800"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        
        <div class="overflow-hidden rounded-2xl shadow bg-white">
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
                    <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-700">
                                
                                <?php echo e(($produk->currentPage() - 1) * $produk->perPage() + $loop->iteration); ?>

                            </td>
                            <td class="px-4 py-3 font-semibold text-blue-800"><?php echo e($item->nama); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                    <?php echo e($item->kategori->nama ?? '-'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold text-green-600">Rp <?php echo e(number_format($item->harga,0,',','.')); ?></td>
                            <td class="px-4 py-3"><?php echo e($item->stok); ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php if($item->foto): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->foto)); ?>" alt="<?php echo e($item->nama); ?>" class="h-20 w-20 object-cover rounded-lg mx-auto border">
                                <?php else: ?>
                                    <span class="text-gray-400 italic text-xs">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="<?php echo e(route('admin.produk.edit', $item->id)); ?>" class="px-3 py-1 rounded bg-blue-600 text-white text-sm">✏️ Edit</a>
                                <form id="delete-form-<?php echo e($item->id); ?>" action="<?php echo e(route('admin.produk.destroy', $item->id)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" onclick="confirmDelete('<?php echo e($item->id); ?>', '<?php echo e($item->stok); ?>', '0')" class="px-3 py-1 rounded bg-red-600 text-white text-sm">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500 italic">Belum ada produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($produk->lastPage() > 1): ?>
            <div class="mt-4 flex justify-end items-center gap-2">
                
                <?php if($produk->previousPageUrl()): ?>
                    <a href="<?php echo e($produk->previousPageUrl()); ?>" class="page-pill inline-block bg-white border px-3 py-1 rounded shadow hover:bg-blue-50">‹ Prev</a>
                <?php else: ?>
                    <span class="page-pill disabled inline-block bg-white border px-3 py-1 rounded">‹ Prev</span>
                <?php endif; ?>

                
                <?php for($i = 1; $i <= $produk->lastPage(); $i++): ?>
                    <?php if($i == $produk->currentPage()): ?>
                        <span class="page-pill active"><?php echo e($i); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($produk->url($i)); ?>" class="page-pill inline-block bg-white border hover:bg-blue-50"><?php echo e($i); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                
                <?php if($produk->nextPageUrl()): ?>
                    <a href="<?php echo e($produk->nextPageUrl()); ?>" class="page-pill inline-block bg-white border px-3 py-1 rounded shadow hover:bg-blue-50">Next ›</a>
                <?php else: ?>
                    <span class="page-pill disabled inline-block bg-white border px-3 py-1 rounded">Next ›</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    
    <script>
        function confirmDelete(id, stok, ordersCount) {
            if (parseInt(stok) > 0) {
                Swal.fire({ icon:'error', title:'Tidak Bisa Dihapus!', text:'Produk masih memiliki stok.', confirmButtonColor:'#2563eb' });
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
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/produk/index.blade.php ENDPATH**/ ?>