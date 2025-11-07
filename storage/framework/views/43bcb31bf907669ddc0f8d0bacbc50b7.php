<?php $__env->startSection('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        background: linear-gradient(135deg, #e0f2fe, #bfdbfe, #93c5fd);
        min-height: 100vh;
    }
    .glass {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row gap-6">

    <!-- 🧍 Kolom Kiri: Daftar Pengguna -->
    <div class="w-full md:w-1/3 glass rounded-2xl p-5">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">Daftar Pengguna</h2>

        <input type="text" id="searchUser" placeholder="Cari pengguna..."
               class="w-full mb-3 px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

        <?php
            $users = $transactions->pluck('user')->unique('id');
        ?>

        <ul id="userList" class="divide-y divide-blue-100 max-h-[500px] overflow-y-auto">
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="py-2 px-3 cursor-pointer hover:bg-blue-100 rounded-md transition"
                    onclick="showTransactions(<?php echo e($user->id); ?>)"
                    data-name="<?php echo e(strtolower($user->name)); ?>"
                    data-id="<?php echo e($user->id); ?>">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-blue-900"><?php echo e($user->name); ?></span>
                        <i class="ri-arrow-right-s-line text-blue-800"></i>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- 📦 Kolom Kanan: Daftar Transaksi -->
    <div class="w-full md:w-2/3 glass rounded-2xl p-5">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">Transaksi Pengguna</h2>

        <input type="text" id="searchTransaction" placeholder="Cari transaksi..."
               class="w-full mb-3 px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

        <div id="transactionList" class="space-y-3">
            <p class="text-gray-600 text-sm">Klik salah satu pengguna untuk melihat transaksinya.</p>
        </div>
    </div>

</div>

<script>

const allTransactions = <?php echo json_encode($transactions, 15, 512) ?>;
const csrfToken = '<?php echo e(csrf_token()); ?>';

function showTransactions(userId) {
    const list = document.getElementById('transactionList');
    list.innerHTML = '';

    const userTransactions = allTransactions.filter(t => t.user_id === userId);

    if (userTransactions.length === 0) {
        list.innerHTML = `<p class="text-gray-600">Tidak ada transaksi untuk pengguna ini.</p>`;
        return;
    }

    userTransactions.forEach(t => {

        const items = (t.items || [])
            .map(i => `<li>${i.produk?.nama ?? '—'} <span class='text-sm text-gray-500'>x${i.quantity}</span></li>`)
            .join('');

        let actionHtml = `
            <div class="mt-3 flex flex-col gap-2">
                 <!-- ✅ CATATAN PENGIRIMAN SELALU ADA DI BAWAH KONFIRM -->
                        <label class="block text-sm font-medium text-green-900 mt-3">Catatan Pengiriman</label>
                        <textarea name="shipping_note" rows="2"
                            class="w-full border border-green-300 rounded-lg p-2 mt-1"
                            placeholder="Contoh: Paket dikirim via JNE..."></textarea>

                <!-- ✅ Tombol Konfirmasi Pesanan (khusus pending) -->
                ${t.status === "pending" ? `
                    <button onclick="toggleConfirm(${t.id})"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        ✅ Konfirmasi Pesanan
                    </button>
                ` : ''}

                <!-- ✅ FORM CATATAN + KONFIRMASI -->
                <div id="confirmForm-${t.id}" class="hidden mt-3 p-3 border border-green-300 bg-green-50 rounded-xl">

                    <form method="POST" action="/admin/transactions/update/${t.id}">
                        <input type="hidden" name="_token" value="${csrfToken}">

                        <label class="block text-sm font-medium text-green-900">Status</label>
                        <select name="status" class="w-full border border-green-300 rounded-lg p-2 mt-1">
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>


                        <button type="submit"
                            class="w-full mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            💾 Simpan Konfirmasi
                        </button>
                    </form>
                </div>

                <!-- ✅ Tombol Edit Status (untuk semua status) -->
                <button onclick="toggleEdit(${t.id})"
                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition text-sm">
                    ✏️ Edit Status
                </button>

                <!-- ✅ FORM EDIT STATUS -->
                <div id="editForm-${t.id}" class="hidden mt-3 p-3 border border-blue-300 bg-blue-50 rounded-xl">
                    <form method="POST" action="/admin/transactions/update/${t.id}">
                        <input type="hidden" name="_token" value="${csrfToken}">

                        <label class="block text-sm font-medium text-blue-900">Status</label>
                        <select name="status" class="w-full border border-blue-300 rounded-lg p-2 mt-1">
                            <option value="pending" ${t.status === "pending" ? "selected" : ""}>Pending</option>
                            <option value="dikirim" ${t.status === "dikirim" ? "selected" : ""}>Dikirim</option>
                            <option value="selesai" ${t.status === "selesai" ? "selected" : ""}>Selesai</option>
                            <option value="dibatalkan" ${t.status === "dibatalkan" ? "selected" : ""}>Dibatalkan</option>
                        </select>

                        <label class="block text-sm font-medium text-blue-900 mt-3">Catatan Pengiriman</label>
                        <textarea name="shipping_note" rows="2"
                            class="w-full border border-blue-300 rounded-lg p-2 mt-1"
                        >${t.shipping_note ?? ''}</textarea>

                        <button type="submit"
                            class="w-full mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            💾 Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        `;

        const card = `
            <div class="transaction-card bg-white rounded-xl p-4 border border-blue-200 shadow-sm hover:shadow-md transition"
                data-search="${t.id} ${t.status}">

                <div class="flex justify-between">
                    <span class="font-semibold text-blue-900">#${t.id}</span>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SamiUSK\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>