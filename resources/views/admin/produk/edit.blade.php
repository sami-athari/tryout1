@extends('layouts.admin')

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
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select bg-white text-dark" required>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" 
                                {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

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
@endsection
