@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-5">

    <!-- Header -->
    <div class="mb-4 p-4 rounded shadow-lg" style="background: linear-gradient(135deg, #1e3a8a, #1d4ed8);">
        <h2 class="fw-bold text-white mb-2">📚 Daftar Produk Bookstore</h2>
        <p class="text-white-50 mb-0">
            Kelola semua koleksi buku dengan mudah. Tambahkan, perbarui, atau hapus produk sesuai kebutuhan.
        </p>
    </div>

    <!-- Tombol Aksi -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.dashboard') }}" 
           class="btn fw-semibold shadow-sm" 
           style="background-color: #facc15; color: #1e3a8a;">
            ← Kembali ke Dashboard
        </a>

        <a href="{{ route('admin.produk.create') }}" 
           class="btn fw-semibold shadow-sm text-white" 
           style="background-color: #2563eb;">
            + Tambah Produk
        </a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
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
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif

    <!-- Tabel Produk -->
    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead style="background: linear-gradient(135deg, #1e40af, #1d4ed8); color: white;">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th style="width: 15%;">Gambar</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $produk)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-primary">{{ $produk->nama }}</td>
                            <td><span class="badge rounded-pill" style="background-color:#2563eb;">{{ $produk->kategori->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>
                                @if ($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}" 
                                         alt="{{ $produk->nama }}" 
                                         class="img-fluid rounded shadow-sm border" 
                                         width="100">
                                @else
                                    <span class="text-muted fst-italic">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                   class="btn btn-sm text-white shadow-sm" 
                                   style="background-color:#2563eb;">
                                    ✏️ Edit
                                </a>
                                <form id="delete-form-{{ $produk->id }}" 
                                      action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                      method="POST" 
                                      class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm text-white shadow-sm" 
                                            style="background-color:#dc2626;" 
                                            onclick="confirmDelete({{ $produk->id }}, {{ $produk->stok }}, {{ $produk->orders_count }})">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted fst-italic">
                                Belum ada produk ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus -->
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
