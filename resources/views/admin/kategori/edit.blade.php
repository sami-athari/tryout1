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
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-lg border-0">
                {{-- Header dengan gradient biru --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #2563eb, #1e40af);">
                    <h4 class="mb-0"> Edit Kategori Buku</h4>
                </div>

                {{-- Body --}}
                <div class="card-body" style="background-color: #f8fafc;">
                    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Kategori --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold text-primary">Nama Kategori</label>
                            <input type="text" name="nama" id="nama"
                                   class="form-control shadow-sm border-primary @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $kategori->nama) }}"
                                   placeholder="Masukkan nama kategori" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold text-primary">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                      class="form-control shadow-sm border-primary @error('deskripsi') is-invalid @enderror"
                                      placeholder="Deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Ganti Foto --}}
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold text-primary">Ganti Gambar (Opsional)</label>
                            <input type="file" name="foto" id="foto"
                                   class="form-control shadow-sm border-primary @error('foto') is-invalid @enderror"
                                   accept="image/*">
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Foto Saat Ini --}}
                        @if($kategori->foto)
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-primary">Gambar Saat Ini:</label><br>
                                <img src="{{ asset('storage/' . $kategori->foto) }}" width="150" alt="Gambar Kategori"
                                     class="rounded shadow border border-2 border-white">
                            </div>
                        @endif

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
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SweetAlert Success --}}
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
@endsection
