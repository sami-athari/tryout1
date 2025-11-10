<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <a href="<?php echo e(route('user.dashboard')); ?>"
       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline mb-6">
        ← Kembali ke Dashboard
    </a>

    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4 font-semibold">
            💬 Chat dengan Admin
        </div>

        <div class="flex flex-wrap gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
            <?php
                $quick = [
                    'Bagaimana status pesanan saya?' => 'Status Pesanan',
                    'Bagaimana cara membayar?' => 'Pembayaran',
                    'Bagaimana cara menghubungi admin?' => 'Kontak',
                    'Ada promo?' => 'Promo'
                ];
            ?>

            <?php $__currentLoopData = $quick; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    onclick="askChatbot('<?php echo e($q); ?>')"
                    class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    <?php echo e($label); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div id="chat-box" class="h-96 overflow-y-auto px-6 py-4 space-y-4 bg-gray-50 dark:bg-gray-900">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex flex-col <?php echo e($msg->sender_id == auth()->id() ? 'items-end' : 'items-start'); ?>">
                    <div class="<?php echo e($msg->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 border dark:border-gray-600 text-gray-800 dark:text-gray-200'); ?>

                                px-4 py-2 rounded-lg max-w-xs">
                        <?php echo e($msg->message); ?>

                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <?php echo e($msg->created_at->format('H:i')); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-500 dark:text-gray-400">Belum ada pesan.</p>
            <?php endif; ?>
        </div>

        <form method="POST" action="<?php echo e(route('chat.send')); ?>"
              class="flex items-center gap-3 border-t dark:border-gray-700 px-6 py-4 bg-white dark:bg-gray-800">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="receiver_id"
                   value="<?php echo e(\App\Models\User::where('role', 'admin')->first()->id); ?>">

            <input type="text" name="message"
                   placeholder="Ketik pesan..."
                   required
                   class="flex-1 border dark:border-gray-600 rounded-lg px-4 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white">

            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Kirim
            </button>
        </form>

        <div class="text-center py-8 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600">
            <h3 class="font-semibold mb-2 dark:text-white">Butuh Bantuan?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-6">Hubungi Admin melalui WhatsApp atau Email</p>

            <div class="flex justify-center gap-8">
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.7 5.4 2 7.8L.5 31.5l7.9-2.1c2.3 1.2 4.9 1.8 7.6 1.8 8.6 0 15.5-6.9 15.5-15.5S24.6.5 16 .5z"/>
                    </svg>
                </a>

                <a href="mailto:sami.athari.z@gmail.com"
                   class="w-12 h-12 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 13.065 1.5 6.75V18a2.25 2.25 0 0 0 2.25 2.25h16.5A2.25 2.25 0 0 0 22.5 18V6.75l-10.5 6.315z"/>
                        <path d="M21.75 4.5H2.25v.527l10.5 6.315 10.5-6.315V5.25z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

    function askChatbot(question) {
        const bubble = document.createElement('div');
        bubble.className = "flex flex-col items-end";
        bubble.innerHTML = `
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg max-w-xs">${question}</div>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sekarang</span>
        `;
        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch("<?php echo e(route('chat.chatbot')); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
            },
            body: JSON.stringify({ question })
        })
        .then(res => res.json())
        .then(data => {
            const bot = document.createElement('div');
            bot.className = "flex flex-col items-start";
            const isDark = document.body.classList.contains('dark-mode');
            bot.innerHTML = `
                <div class="${isDark ? 'bg-gray-700 border-gray-600 text-gray-200' : 'bg-white border text-gray-800'} border px-4 py-2 rounded-lg max-w-xs">${data.answer}</div>
                <span class="text-xs ${isDark ? 'text-gray-400' : 'text-gray-500'} mt-1">Sekarang</span>
            `;
            chatBox.appendChild(bot);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/user/chat.blade.php ENDPATH**/ ?>