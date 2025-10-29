@extends('layouts.admin')

@section('styles')
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
@endsection

@section('content')
<div class="flex flex-col md:flex-row gap-6">

    <!-- 🧍 Kolom Kiri: Daftar Pengguna -->
    <div class="w-full md:w-1/3 glass rounded-2xl p-5">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">Daftar Pengguna</h2>

        <input type="text" id="searchUser" placeholder="Cari pengguna..."
               class="w-full mb-3 px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

        @php
            $users = $transactions->pluck('user')->unique('id');
        @endphp

        <ul id="userList" class="divide-y divide-blue-100 max-h-[500px] overflow-y-auto">
            @foreach($users as $user)
                <li class="py-2 px-3 cursor-pointer hover:bg-blue-100 rounded-md transition"
                    onclick="showTransactions({{ $user->id }})"
                    data-name="{{ strtolower($user->name) }}"
                    data-id="{{ $user->id }}">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-blue-900">{{ $user->name }}</span>
                        <i class="ri-arrow-right-s-line text-blue-800"></i>
                    </div>
                </li>
            @endforeach
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
    // 🔍 Filter User saat mengetik
    document.getElementById('searchUser').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#userList li').forEach(li => {
            li.style.display = li.dataset.name.includes(search) ? 'block' : 'none';
        });
    });

    // 🚀 Tekan ENTER untuk langsung buka user yang cocok
    document.getElementById('searchUser').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const search = this.value.toLowerCase();
            const match = Array.from(document.querySelectorAll('#userList li'))
                .find(li => li.dataset.name.includes(search));
            if (match) {
                const userId = match.dataset.id;
                showTransactions(parseInt(userId));
                match.scrollIntoView({ behavior: 'smooth', block: 'center' });
                match.classList.add('bg-blue-200');
                setTimeout(() => match.classList.remove('bg-blue-200'), 1500);
            } else {
                document.getElementById('transactionList').innerHTML =
                    `<p class='text-gray-600'>Pengguna tidak ditemukan.</p>`;
            }
        }
    });

    // 🔍 Filter Transaksi
    document.getElementById('searchTransaction').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#transactionList .transaction-card').forEach(card => {
            card.style.display = card.dataset.search.includes(search) ? 'block' : 'none';
        });
    });

    // 📦 Tampilkan transaksi sesuai user
    const allTransactions = @json($transactions);

    function showTransactions(userId) {
        const list = document.getElementById('transactionList');
        list.innerHTML = '';

        const userTransactions = allTransactions.filter(t => t.user_id === userId);

        if (userTransactions.length === 0) {
            list.innerHTML = `<p class="text-gray-600">Tidak ada transaksi untuk pengguna ini.</p>`;
            return;
        }

        userTransactions.forEach(t => {
            const items = t.items.map(i => `<li>${i.produk.nama} <span class='text-sm text-gray-500'>x${i.quantity}</span></li>`).join('');
            const card = `
                <div class="transaction-card bg-white rounded-xl p-4 border border-blue-200 shadow-sm hover:shadow-md transition"
                     data-search="${t.id} ${t.status} ${t.user.name}">
                    <div class="flex justify-between">
                        <span class="font-semibold text-blue-900">#${t.id}</span>
                        <span class="text-sm text-gray-600">${t.status}</span>
                    </div>
                    <ul class="list-disc ml-5 mt-2 text-gray-700">${items}</ul>
                    <p class="mt-2 text-sm text-gray-600">Total: Rp${t.total.toLocaleString()}</p>
                </div>
            `;
            list.innerHTML += card;
        });
    }
</script>
@endsection
