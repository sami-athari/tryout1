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
    </style>
@endsection

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow" style="width: 550px; border-radius: 12px; background-color: #1c43a8; color: white;">
        <div class="card-header text-white text-center rounded-top"
             style="border-radius: 12px 12px 0 0; background: linear-gradient(135deg, #1c43a8, #2d5fd0);">
            <h5 class="mb-0">Edit Produk</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control bg-white text-dark"
                           value="{{ $produk->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="form-control bg-white text-dark" required>{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control bg-white text-dark"
                           value="{{ $produk->harga }}" required>
                </div>
                 {{-- Bagian kategori diperbaiki --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <select name="kategori_id" class="form-select border border-gray-300 shadow-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $item)
                            <option value="{{ $item->id }}"
                                {{ $produk->kategori_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control bg-white text-dark"
                           value="{{ old('stok', $produk->stok) }}" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Gambar Produk (opsional)</label>
                    <input type="file" name="foto" id="foto" class="form-control bg-white text-dark">
                    @if ($produk->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $produk->foto) }}"
                                 alt="Foto Produk" width="150"
                                 style="border-radius: 8px; border: 2px solid #fff;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-light btn-sm">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm"
                            style="background: linear-gradient(135deg, #2d5fd0, #1a3c87); border: none;">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 Notifikasi --}}
<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#1d4ed8'
        })
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#1d4ed8'
        })
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#1d4ed8'
        })
    @endif
</script>
@endsection
