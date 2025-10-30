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
<div class="container mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-6">Edit About Us</h1>

    
    <form action="<?php echo e(route('admin.about.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?> 

        <div class="mb-4">
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="title" class="w-full border p-2 rounded"
                value="<?php echo e(old('title', $about->title ?? '')); ?>">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded"><?php echo e(old('description', $about->description ?? '')); ?></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Misi Kami</label>
            <textarea name="mission" rows="4" class="w-full border p-2 rounded"><?php echo e(old('mission', $about->mission ?? '')); ?></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Kenapa Seilmu?</label>
            <textarea name="why" rows="4" class="w-full border p-2 rounded"><?php echo e(old('why', $about->why ?? '')); ?></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Tagline</label>
            <input type="text" name="tagline" class="w-full border p-2 rounded"
                value="<?php echo e(old('tagline', $about->tagline ?? '')); ?>">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Gambar</label>
            <input type="file" name="image">
            <?php if($about && $about->image): ?>
                <img src="<?php echo e(asset('storage/' . $about->image)); ?>" class="h-24 mt-2 rounded shadow">
            <?php endif; ?>
        </div>

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/admin/about/edit.blade.php ENDPATH**/ ?>