@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-8 rounded-2xl shadow-xl p-6 bg-gradient-to-r from-blue-900 to-blue-600 text-white">
        <h2 class="text-3xl font-extrabold mb-2">📚 Daftar Produk Bookstore</h2>
        <p class="text-blue-100">
            Kelola semua koleksi buku dengan mudah. Tambahkan, perbarui, atau hapus produk sesuai kebutuhan.
        </p>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="px-5 py-2 rounded-xl font-semibold shadow-md bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition">
            ← Kembali ke Dashboard
        </a>

        <a href="{{ route('admin.produk.create') }}"
           class="px-5 py-2 rounded-xl font-semibold shadow-md bg-blue-600 text-white hover:bg-blue-700 transition">
            + Tambah Produk
        </a>
    </div>

    {{-- Notifikasi SweetAlert --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif

    {{-- Tabel Produk --}}
    <div class="overflow-hidden rounded-2xl shadow-xl bg-white">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gradient-to-r from-blue-800 to-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-center">Gambar</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $index => $produk)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-4 py-3 font-bold text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-semibold text-blue-800">{{ $produk->nama }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $produk->kategori->nama ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-bold text-green-600">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">{{ $produk->stok }}</td>
                        <td class="px-4 py-3 text-center">
                            @if ($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}"
                                     alt="{{ $produk->nama }}"
                                     class="h-20 w-20 object-cover rounded-lg shadow-md mx-auto border">
                            @else
                                <span class="italic text-gray-400">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('admin.produk.edit', $produk->id) }}"
                               class="px-3 py-1 rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm text-sm">
                                ✏️ Edit
                            </a>
                            <form id="delete-form-{{ $produk->id }}"
                                  action="{{ route('admin.produk.destroy', $produk->id) }}"
                                  method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="confirmDelete('{{ $produk->id }}', '{{ $produk->stok }}', '{{ $produk->orders_count }}')"
                                        class="px-3 py-1 rounded-lg text-white bg-red-600 hover:bg-red-700 shadow-sm text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 italic">
                            Belum ada produk ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Konfirmasi Hapus --}}
<script>
    function confirmDelete(id, stok, ordersCount) {
        if (stok > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Dihapus!',
                text: 'Produk masih memiliki stok. Harap habiskan stok terlebih dahulu.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        if (ordersCount > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Dihapus!',
                text: 'Produk ini masih ada dalam pesanan. Tidak bisa dihapus.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data produk akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#2563eb',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
