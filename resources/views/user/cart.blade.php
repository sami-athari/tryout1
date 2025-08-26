@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8 text-center">🛒 Keranjang Belanja</h1>

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
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-center">Foto</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-center">Stok Tersisa</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <tr data-item-id="{{ $item->id }}" data-stok="{{ $item->produk->stok }}" data-harga="{{ $item->produk->harga }}">
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->produk->nama }}</td>
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="Foto Produk" class="w-16 h-16 object-cover rounded-md mx-auto">
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $item->produk->kategori->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-medium text-blue-800">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button type="button" class="minus-btn px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300">−</button>
                                    <span class="qty-text px-3 py-1 border rounded-md bg-gray-50">{{ $item->jumlah }}</span>
                                    <button type="button" class="plus-btn px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300">+</button>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center stok-text">
                                {{ $item->produk->stok - $item->jumlah }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div id="total" class="text-xl font-bold text-right mt-6 text-blue-900">
            Total: Rp {{ number_format($items->sum(fn($i) => $i->produk->harga * $i->jumlah),0,',','.') }}
        </div>

        {{-- Tombol Checkout --}}
        <div class="mt-6 text-right">
            <a href="{{ route('user.checkout.form') }}"
               class="inline-block px-6 py-3 bg-blue-900 text-white rounded-lg shadow hover:bg-blue-800 transition">
                Checkout Sekarang
            </a>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">Keranjangmu masih kosong, yuk tambahkan produk! 🛍</p>
            <a href="{{ route('user.dashboard') }}"
               class="mt-4 inline-block px-5 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Belanja Sekarang
            </a>
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
            body: JSON.stringify({ quantity: newQty })
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
