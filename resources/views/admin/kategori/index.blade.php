@extends('layouts.admin')

@section('styles')
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
    /* Semua gambar di kolom gambar jadi seragam */
    .img-kategori {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        border: 1px solid #e5e7eb;
    }
</style>
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-5">

    <!-- HEADER -->
    <div class="mb-4 p-4 rounded shadow-sm" style="background: linear-gradient(to right, #1e3a8a, #2563eb);">
        <h2 class="fw-bold text-white mb-2">📚 Daftar Kategori Buku</h2>
        <p class="text-white mb-0">Kelola kategori buku dengan mudah: tambah, edit, atau hapus sesuai kebutuhan Anda.</p>
    </div>

    <!-- BUTTON & SEARCH -->
    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <a href="{{ route('admin.dashboard') }}"
           class="btn fw-semibold shadow-sm"
           style="background-color: #facc15; color: black; border-radius: 8px;">
            ← Kembali ke Dashboard
        </a>

        <form method="GET" action="{{ route('admin.kategori.index') }}" class="d-flex align-items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                   class="form-control border-primary rounded px-3" style="min-width: 200px;">
            <button type="submit" class="btn text-white fw-semibold shadow-sm"
                    style="background: linear-gradient(to right, #2563eb, #3b82f6); border-radius: 8px;">
                🔍 Cari
            </button>
        </form>

        <div class="d-flex align-items-center gap-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggleGambar" checked>
                <label class="form-check-label fw-semibold" for="toggleGambar">Tampilkan Kolom Gambar</label>
            </div>

            <span class="badge bg-primary me-2 px-3 py-2 shadow-sm" style="font-size: 0.9rem;">
                Total: {{ $kategoris->total() }} Kategori
            </span>

            <a href="{{ route('admin.kategori.create') }}" class="btn fw-semibold text-white shadow-sm"
               style="background: linear-gradient(to right, #2563eb, #3b82f6); border-radius: 8px;">
                + Tambah Kategori
            </a>
        </div>
    </div>

    <!-- ALERT -->
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
                showConfirmButton: true
            });
        </script>
    @endif

    <!-- TABLE -->
    <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center table-hover">
                <thead style="background: linear-gradient(to right, #1e3a8a, #2563eb); color: white;">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="kolom-gambar" style="width: 20%;">Gambar</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $index => $kategori)
                        <tr style="transition: background 0.3s ease;"
                            onmouseover="this.style.backgroundColor='#e0f2fe'"
                            onmouseout="this.style.backgroundColor='white'">
                            <td class="fw-bold">{{ $kategoris->firstItem() + $index }}</td>
                            <td class="fw-semibold text-primary">{{ $kategori->nama }}</td>
                            <td>{{ $kategori->deskripsi ?? '—' }}</td>
                            <td class="kolom-gambar">
                                @if (!empty($kategori->foto))
                                    <img src="{{ asset('storage/' . $kategori->foto) }}"
                                         alt="{{ $kategori->nama }}"
                                         class="img-kategori">
                                @else
                                    <span class="text-muted fst-italic">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                   class="btn btn-sm fw-semibold text-white shadow-sm me-2"
                                   style="background: linear-gradient(to right, #22c55e, #16a34a); border-radius: 6px;">
                                    ✏️ Edit
                                </a>

                                @if ($kategori->bukus_count == 0)
                                    <form id="delete-form-{{ $kategori->id }}"
                                          action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm fw-semibold text-white shadow-sm"
                                                style="background: linear-gradient(to right, #ef4444, #dc2626); border-radius: 6px;"
                                                onclick="confirmDelete({{ $kategori->id }})">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                            class="btn btn-sm fw-semibold text-white shadow-sm"
                                            style="background: gray; border-radius: 6px;" disabled>
                                        🔒 Tidak Bisa Dihapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada kategori ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $kategoris->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data kategori akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#3b82f6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    document.getElementById("toggleGambar").addEventListener("change", function() {
        const display = this.checked ? "" : "none";
        document.querySelectorAll(".kolom-gambar").forEach(el => {
            el.style.display = display;
        });
    });
</script>
@endsection
