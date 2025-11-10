<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[85vh] py-12 px-4">
    <div class="bg-white border rounded-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">
            Register Account
        </h2>

        <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

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

            <div>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                       placeholder="Full Name"
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

            <div>
                <input type="password" name="password" required placeholder="Password"
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

            <div>
                <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li>Minimum 8 characters</li>
                <li>Include numbers & symbols</li>
            </ul>

            <div class="flex items-start space-x-2 text-sm">
                <input type="checkbox" id="privacy-check" required
                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="privacy-check" class="text-gray-600">
                    By registering, you agree to
                    <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Register
            </button>

            <p class="text-center text-gray-600 text-sm">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:underline font-medium">Login</a>
            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/auth/register.blade.php ENDPATH**/ ?>