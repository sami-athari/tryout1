<?php $__env->startSection('styles'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd, #7dd3fc);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-12 px-6">
    
    <h1 class="text-4xl font-extrabold mb-8 text-center text-gray-900 tracking-wide">
        📋 Daftar Akun User
    </h1>

    
    <div class="mb-6 text-center">
        <span class="text-lg text-gray-800">
            Total akun terdaftar:
            <strong class="text-blue-700"><?php echo e($total); ?></strong>
        </span>
    </div>

    
    <div class="overflow-hidden shadow-2xl glass">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white uppercase text-xs tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">#</th>
                    <th class="py-4 px-6 text-left">Nama</th>
                    <th class="py-4 px-6 text-left">Email</th>
                    <th class="py-4 px-6 text-left">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-blue-50 transition duration-200">
                    <td class="py-4 px-6 font-semibold text-gray-700">
                        <?php echo e($loop->iteration + ($users->currentPage() - 1) * $users->perPage()); ?>

                    </td>
                    <td class="py-4 px-6 text-gray-900"><?php echo e($user->name); ?></td>
                    <td class="py-4 px-6 text-gray-700"><?php echo e($user->email); ?></td>
                    <td class="py-4 px-6 text-gray-600">
                        <?php echo e($user->created_at->format('d M Y')); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center py-6 text-red-500 font-medium">
                        Belum ada user terdaftar.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="mt-8 flex justify-center">
        <?php echo e($users->links('pagination::tailwind')); ?>

    </div>

    
    <div class="mt-10 text-center">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="inline-block px-6 py-3 rounded-xl font-semibold shadow-md bg-yellow-400 text-gray-900 hover:bg-yellow-500 transition">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/users/index.blade.php ENDPATH**/ ?>