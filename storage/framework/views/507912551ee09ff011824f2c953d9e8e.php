<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">
            Masuk ke <?php echo e(config('app.name', 'Seilmu')); ?>

        </h2>

        <!-- Form -->
        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                       required autofocus placeholder="Email"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div>
                <input id="password" type="password" name="password" required placeholder="Kata Sandi"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Lupa password -->
            <?php if(Route::has('password.request')): ?>
                <div class="text-right">
                    <a href="<?php echo e(route('password.request')); ?>"
                       class="text-sm text-blue-700 hover:underline">Lupa Kata Sandi?</a>
                </div>
            <?php endif; ?>

            <!-- Tombol Login -->
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                Masuk
            </button>

            <!-- Link Register -->
            <p class="text-center text-gray-600 text-sm">
                Belum punya akun?
                <a href="<?php echo e(route('register')); ?>" class="text-blue-700 hover:underline font-medium">Daftar</a>
            </p>

            <!-- Kembali ke Beranda -->
            <p class="text-center mt-4">
                <a href="<?php echo e(url('/')); ?>" class="text-gray-500 hover:text-blue-700 text-sm">
                    ← Kembali ke Beranda
                </a>
            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/auth/login.blade.php ENDPATH**/ ?>