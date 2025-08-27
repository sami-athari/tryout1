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
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: #0404c4;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
        color: white;
    }

    .form-container label {
        color: #ffffff;
        font-weight: 600;
    }

    .form-control {
        background-color: #ffffff;
        border: 1px solid #ccc;
        color: #000000;
    }

    .form-control::placeholder {
        color: #666;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        font-weight: bold;
        padding: 10px 20px;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .form-title {
        color: #ffffff;
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }
</style>

<div class="form-container">
    <div class="form-title">Edit Kategori Buku</div>

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Kategori --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kategori->nama) }}" required>
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Ganti Foto --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
            @error('foto')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Foto Saat Ini --}}
        @if($kategori->foto)
            <div class="mb-3">
                <label>Gambar Saat Ini:</label><br>
                <img src="{{ asset('storage/' . $kategori->foto) }}" width="150" alt="Gambar Kategori" style="border-radius: 10px;">
            </div>
        @endif

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>

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
