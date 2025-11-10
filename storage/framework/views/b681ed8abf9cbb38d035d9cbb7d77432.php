<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- User List -->
        <div class="md:col-span-1 bg-white border rounded-lg p-5">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Users</h2>

            <input type="text" id="searchUser" placeholder="Search users..."
                   class="w-full mb-3 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-200">

            <?php
                $users = $transactions->pluck('user')->unique('id');
            ?>

            <ul id="userList" class="divide-y max-h-[500px] overflow-y-auto">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="py-2 px-3 cursor-pointer hover:bg-gray-50 rounded transition"
                        onclick="showTransactions(<?php echo e($user->id); ?>)"
                        data-name="<?php echo e(strtolower($user->name)); ?>"
                        data-id="<?php echo e($user->id); ?>">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-900"><?php echo e($user->name); ?></span>
                            <span class="text-gray-400">→</span>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- Transactions List -->
        <div class="md:col-span-2 bg-white border rounded-lg p-5">
            <h2 class="text-lg font-bold text-gray-900 mb-4">User Transactions</h2>

            <input type="text" id="searchTransaction" placeholder="Search transactions..."
                   class="w-full mb-3 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-200">

            <div id="transactionList" class="space-y-3">
                <p class="text-gray-600 text-sm">Click a user to view their transactions.</p>
            </div>
        </div>

    </div>
</div>

<script>
    const allTransactions = <?php echo json_encode($transactions, 15, 512) ?>;
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    const adminBase = '<?php echo e(url("admin")); ?>';

    function showTransactions(userId) {
        const list = document.getElementById('transactionList');
        list.innerHTML = '';

        const userTransactions = allTransactions.filter(t => t.user_id === userId);

        if (userTransactions.length === 0) {
            list.innerHTML = `<p class="text-gray-600">No transactions for this user.</p>`;
            return;
        }

        userTransactions.forEach(t => {
            const items = (t.items || [])
                .map(i => `<li>${i.produk?.nama ?? '—'} <span class='text-sm text-gray-500'>x${i.jumlah}</span></li>`)
                .join('');

            let actionHtml = `
                <div class="mt-3 flex flex-col gap-2">

                    ${t.status === "pending" ? `
                        <button onclick="toggleConfirm(${t.id})"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                            ✓ Confirm Order
                        </button>
                    ` : ''}

                    <div id="confirmForm-${t.id}" class="hidden mt-3 p-3 border bg-green-50 rounded-lg">
                        <form method="POST" action="${adminBase}/transactions/update/${t.id}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <label class="block text-sm font-medium text-gray-900 mb-1">Status</label>
                            <select name="status" class="w-full border rounded-lg p-2 mb-2">
                                <option value="dikirim">Shipped</option>
                                <option value="selesai">Completed</option>
                                <option value="dibatalkan">Cancelled</option>
                            </select>

                            <label class="block text-sm font-medium text-gray-900 mb-1">Shipping Note</label>
                            <textarea name="shipping_note" rows="2"
                                class="w-full border rounded-lg p-2 mb-2"
                                placeholder="e.g., Package shipped via JNE..."></textarea>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Save Confirmation
                            </button>
                        </form>
                    </div>

                    <button onclick="toggleEdit(${t.id})"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                        Edit Status
                    </button>

                    <div id="editForm-${t.id}" class="hidden mt-3 p-3 border bg-blue-50 rounded-lg">
                        <form method="POST" action="${adminBase}/transactions/update/${t.id}">
                            <input type="hidden" name="_token" value="${csrfToken}">

                            <label class="block text-sm font-medium text-gray-900 mb-1">Status</label>
                            <select name="status" class="w-full border rounded-lg p-2 mb-2">
                                <option value="pending" ${t.status === "pending" ? "selected" : ""}>Pending</option>
                                <option value="dikirim" ${t.status === "dikirim" ? "selected" : ""}>Shipped</option>
                                <option value="selesai" ${t.status === "selesai" ? "selected" : ""}>Completed</option>
                                <option value="dibatalkan" ${t.status === "dibatalkan" ? "selected" : ""}>Cancelled</option>
                            </select>

                            <label class="block text-sm font-medium text-gray-900 mb-1">Shipping Note</label>
                            <textarea name="shipping_note" rows="2"
                                class="w-full border rounded-lg p-2 mb-2"
                            >${t.shipping_note ?? ''}</textarea>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save Changes
                            </button>
                        </form>
                    </div>

                </div>
            `;

            const card = `
                <div class="transaction-card bg-white border rounded-lg p-4 hover:shadow-lg transition"
                    data-search="${t.id} ${t.status}">

                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-900">#${t.id}</span>
                        <span class="text-sm text-gray-600 capitalize">${t.status}</span>
                    </div>

                    <ul class="ml-5 mt-2 text-gray-700 list-disc">${items}</ul>

                    <p class="mt-2 text-sm text-gray-600">Total: Rp${(t.total ?? 0).toLocaleString()}</p>

                    ${actionHtml}
                </div>
            `;

            list.innerHTML += card;
        });
    }

    function toggleConfirm(id) {
        document.getElementById(`confirmForm-${id}`).classList.toggle('hidden');
    }

    function toggleEdit(id) {
        document.getElementById(`editForm-${id}`).classList.toggle('hidden');
    }
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\samia\OneDrive\Documents\Github\tryout1\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>