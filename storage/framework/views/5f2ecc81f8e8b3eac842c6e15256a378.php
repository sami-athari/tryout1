<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[85vh]">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">
            Daftar Akun <?php echo e(config('app.name', 'Seilmu')); ?>

        </h2>

        <!-- Form -->
        <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                       placeholder="Email"
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

            <!-- Nama -->
            <div>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                       placeholder="Nama Lengkap"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <?php $__errorArgs = ['name'];
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
                <input type="password" name="password" required placeholder="Kata Sandi"
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

            <!-- Konfirmasi Password -->
            <div>
                <input type="password" name="password_confirmation" required placeholder="Konfirmasi Kata Sandi"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Tips Password -->
            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li>Minimum 8 karakter</li>
                <li>Sertakan angka & simbol</li>
            </ul>

            <!-- Checkbox -->
            <div class="flex items-start space-x-2 text-sm">
                <input type="checkbox" id="privacy-check" required
                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="privacy-check" class="text-gray-600">
                    Dengan mendaftar, kamu menyetujui
                    <a href="#" class="text-blue-700 hover:underline">Kebijakan Privasi Seilmu.com</a>
                </label>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                    class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                Daftar
            </button>

            <!-- Link Login -->
            <p class="text-center text-gray-600 text-sm">
                Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" class="text-blue-700 hover:underline font-medium">Masuk</a>
            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/auth/register.blade.php ENDPATH**/ ?>