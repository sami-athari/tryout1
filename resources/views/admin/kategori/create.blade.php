@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-lg border-0">
                {{-- Header dengan gradient biru --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #2563eb, #1e40af);">
                    <h4 class="mb-0">➕ Tambah Kategori Buku</h4>
                </div>

                {{-- Body --}}
                <div class="card-body" style="background-color: #f8fafc;">
                    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Kategori --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold text-primary">Nama Kategori</label>
                            <input type="text" name="nama" id="nama" 
                                   class="form-control shadow-sm border-primary @error('nama') is-invalid @enderror" 
                                   placeholder="Masukkan nama kategori" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Deskripsi Kategori --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold text-primary">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" 
                                      class="form-control shadow-sm border-primary @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Deskripsi kategori..."></textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Gambar Kategori --}}
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold text-primary">Gambar Kategori</label>
                            <input type="file" name="foto" id="foto" 
                                   class="form-control shadow-sm border-primary @error('foto') is-invalid @enderror" 
                                   accept="image/*" required>
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori.index') }}" 
                               class="btn fw-semibold px-4" 
                               style="background-color: #94a3b8; color:white;">
                                ← Kembali
                            </a>
                            <button type="submit" 
                                    class="btn fw-semibold px-4" 
                                    style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color:white;">
                                💾 Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
