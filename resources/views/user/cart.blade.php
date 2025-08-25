@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-extrabold text-white mb-6">🛒 Keranjang Belanja</h1>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 1800,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($items->count())
        <div class="bg-white p-6 rounded-xl shadow-2xl overflow-x-auto">
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="text-gray-700 border-b border-gray-300 text-left">
                        <th class="py-3">📚 Produk</th>
                        <th class="py-3">🖼️ Foto</th>
                        <th class="py-3">🏷️ Kategori</th>
                        <th class="py-3">💰 Harga</th>
                        <th class="py-3 text-center">🔢 Jumlah</th>
                        <th class="py-3 text-center">📦 Stok Tersisa</th>
                        <th class="py-3 text-center">🧹 Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr data-item-id="{{ $item->id }}" data-stok="{{ $item->produk->stok }}" data-harga="{{ $item->produk->harga }}" class="border-b border-gray-200 hover:bg-gray-100 transition">
                            <td class="py-4 font-semibold text-gray-800">{{ $item->produk->nama }}</td>
                            <td class="py-4">
                                <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="Foto Produk" class="w-16 h-16 object-cover rounded-lg shadow">
                            </td>
                            <td class="py-4 text-gray-700">{{ $item->produk->kategori->nama ?? '-' }}</td>
                            <td class="py-4 text-gray-600">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td class="py-4 text-center">
                                <div class="flex justify-center items-center gap-1">
                                    {{-- Minus --}}
                                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-black font-bold rounded minus-btn">−</button>

                                    {{-- Jumlah --}}
                                    <span class="w-12 text-center font-bold text-black qty-text">{{ $item->jumlah }}</span>

                                    {{-- Plus --}}
                                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-black font-bold rounded plus-btn">+</button>
                                </div>
                            </td>
                            <td class="py-4 text-center font-medium stok-text {{ $item->produk->stok - $item->jumlah > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item->produk->stok - $item->jumlah }}
                            </td>
                            <td class="py-4 text-center">
                                <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800 font-semibold delete-btn">Hapus 🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Total --}}
            <div id="total" class="mt-6 text-right text-lg font-bold text-gray-800">
                Total: Rp {{ number_format($items->sum(fn($i) => $i->produk->harga * $i->jumlah),0,',','.') }}
            </div>

            {{-- Tombol Checkout --}}
            <div class="mt-4 flex justify-end">
                <a href="{{ route('user.checkout.form') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-full font-bold shadow-lg">
                    ✅ Checkout Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="text-center text-white text-lg font-medium">
            🧺 Keranjangmu masih kosong, yuk tambahkan produk!
        </div>
    @endif
</div>

<script>
    // Konfirmasi hapus
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Produk?',
                text: "Produk akan dihapus dari keranjang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // Update total harga
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('tr[data-item-id]').forEach(row => {
            const qty = parseInt(row.querySelector('.qty-text').textContent);
            const harga = parseInt(row.dataset.harga);
            total += qty * harga;
        });
        document.getElementById('total').textContent = 'Total: Rp ' + total.toLocaleString('id-ID');
    }

    // Update jumlah & stok, sekaligus simpan ke database
    function updateQty(row, delta) {
        const qtySpan = row.querySelector('.qty-text');
        let currentQty = parseInt(qtySpan.textContent);
        const stokAsli = parseInt(row.dataset.stok);

        let newQty = currentQty + delta;
        if(newQty < 1) newQty = 1;
        if(newQty > stokAsli) newQty = stokAsli;

        // Update tampilan jumlah & stok tersisa
        qtySpan.textContent = newQty;
        const stokCell = row.querySelector('.stok-text');
        stokCell.textContent = stokAsli - newQty;
        stokCell.className = 'py-4 text-center font-medium stok-text ' + (stokAsli - newQty > 0 ? 'text-green-600' : 'text-red-600');

        // Update total
        updateTotal();

        // Update ke server
        const itemId = row.dataset.itemId;
        fetch('{{ url("/user/cart") }}/' + itemId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQty }) // tetap pakai "quantity" untuk request
        })
        .then(res => res.json())
        .then(data => {
            if(!data.success) {
                Swal.fire('Error', 'Gagal update jumlah', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Gagal menghubungi server', 'error');
        });
    }

    // Event listener plus/minus
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const row = this.closest('tr');
            updateQty(row, -1);
        });
    });
    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const row = this.closest('tr');
            updateQty(row, 1);
        });
    });
</script>
@endsection
