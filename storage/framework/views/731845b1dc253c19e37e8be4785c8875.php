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

<a href="<?php echo e(route('admin.dashboard')); ?>"
   class="px-4 py-2 rounded-lg font-semibold shadow-md transition
          bg-blue-600 hover:bg-blue-700 text-white mb-4 inline-block">
    ← Kembali ke Dashboard
</a>

<style>
    .chat-container {
        height: 75vh;
        display: flex;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        background-color: #f0f4f8;
    }

    /* Sidebar User */
    .sidebar {
        width: 25%;
        background: linear-gradient(to bottom, #1e40af, #2563eb);
        color: white;
        padding: 1rem;
        overflow-y: auto;
    }

    .sidebar h4 {
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .user-link {
        display: block;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        color: white;
        margin-bottom: 0.25rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .user-link.active {
        background-color: #3b82f6;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    .user-link:hover {
        background-color: #1d4ed8;
    }

    /* Chat Area */
    .chat-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #e0f2fe;
        border-left: 1px solid #93c5fd;
    }

    .chat-header {
        background-color: #3b82f6;
        color: white;
        padding: 1rem;
        font-weight: bold;
        border-bottom: 1px solid #2563eb;
    }

    .chat-messages {
        flex: 1;
        padding: 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .chat-bubble {
        padding: 0.75rem 1rem;
        border-radius: 20px;
        max-width: 65%;
        word-wrap: break-word;
        font-size: 0.95rem;
        line-height: 1.4;
        position: relative;
        transition: all 0.2s;
    }

    .from-admin {
        background-color: #2563eb;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .from-user {
        background-color: #93c5fd;
        color: #1e3a8a;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .chat-time {
        font-size: 0.7rem;
        opacity: 0.6;
        margin-top: 3px;
        text-align: right;
    }

    /* Form Chat */
    .chat-form {
        display: flex;
        padding: 0.75rem 1rem;
        gap: 0.5rem;
        background-color: #bfdbfe;
        border-top: 1px solid #93c5fd;
    }

    .chat-form input[type="text"] {
        flex: 1;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        border: 1px solid #3b82f6;
        outline: none;
        transition: all 0.2s;
    }

    .chat-form input[type="text"]:focus {
        border-color: #2563eb;
        box-shadow: 0 0 5px rgba(37,99,235,0.5);
    }

    .chat-form button {
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        font-weight: bold;
        transition: all 0.2s;
    }

    .chat-form button:hover {
        background-color: #1d4ed8;
    }
</style>

<div class="chat-container">
    <!-- Sidebar kiri -->
    <div class="sidebar">
        <h4>📋 Daftar User</h4>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('chat.index', ['user_id' => $u->id])); ?>"
               class="user-link <?php echo e(request('user_id') == $u->id ? 'active' : ''); ?>">
                <?php echo e($u->name); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Chat Area -->
    <div class="chat-area">
        <?php if($selectedUser): ?>
            <div class="chat-header">💬 Chat dengan <?php echo e($selectedUser->name); ?></div>

            <div class="chat-messages" id="chat-box">
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="chat-bubble <?php echo e($msg->sender_id == auth()->id() ? 'from-admin' : 'from-user'); ?>">
                        <div><?php echo e($msg->message); ?></div>
                        <div class="chat-time"><?php echo e($msg->created_at->format('H:i')); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-700">Belum ada pesan.</p>
                <?php endif; ?>
            </div>

            <form action="<?php echo e(route('chat.send')); ?>" method="POST" class="chat-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="receiver_id" value="<?php echo e($selectedUser->id); ?>">
                <input type="text" name="message" placeholder="Tulis pesan..." required>
                <button type="submit">Kirim</button>
            </form>
        <?php else: ?>
            <div class="flex items-center justify-center h-full text-blue-700">
                <p>Pilih user di sebelah kiri untuk mulai chat.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/admin/chat.blade.php ENDPATH**/ ?>