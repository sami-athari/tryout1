<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-lg" style="width: 550px; border-radius: 16px; background: linear-gradient(135deg, #1d4ed8, #2563eb); color: white;">
        <div class="card-header text-white text-center" style="border-radius: 16px 16px 0 0; background: linear-gradient(135deg, #1e40af, #1d4ed8);">
            <h5 class="mb-0 fw-bold">Tambah Produk</h5>
        </div>
        <div class="card-body p-4" style="background-color: #fafafb; border-radius: 0 0 16px 16px; color: #f7f7f8;">
            <form action="<?php echo e(route('admin.produk.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <select name="kategori_id" class="form-select border border-gray-300 shadow-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->nama); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Produk</label>
                    <input type="text" name="nama" class="form-control border border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control border border-gray-300 shadow-sm" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Harga</label>
                    <input type="number" name="harga" class="form-control border border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold text-dark">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control border border-gray-300 shadow-sm" value="<?php echo e(old('stok')); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Foto Produk</label>
                    <input type="file" name="foto" class="form-control border border-gray-300 shadow-sm" required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo e(route('admin.produk.index')); ?>" class="btn btn-outline-primary btn-sm px-4 py-2">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 py-2" style="background: linear-gradient(135deg, #1e40af, #2563eb); border: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    <?php if($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: `<?php echo implode('<br>', $errors->all()); ?>`,
            confirmButtonColor: '#1d4ed8'
        })
    <?php endif; ?>

    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "<?php echo e(session('success')); ?>",
            confirmButtonColor: '#1d4ed8'
        })
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "<?php echo e(session('error')); ?>",
            confirmButtonColor: '#1d4ed8'
        })
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/produk/create.blade.php ENDPATH**/ ?>