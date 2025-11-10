<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Login to <?php echo e(config('app.name', 'Seilmu')); ?>

        </h2>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

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

            <div>
                <input id="password" type="password" name="password" required placeholder="Password"
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

            <?php if(Route::has('password.request')): ?>
                <div class="text-right">
                    <a href="<?php echo e(route('password.request')); ?>"
                       class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>
            <?php endif; ?>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Login
            </button>

            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" class="text-blue-600 hover:underline font-medium">Register</a>
            </p>

            <p class="text-center mt-4">
                <a href="<?php echo e(url('/')); ?>" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/auth/login.blade.php ENDPATH**/ ?>