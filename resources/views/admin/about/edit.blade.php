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
<div class="container mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-6">Edit About Us</h1>

    {{-- ✅ form action harus ke route update + id --}}
    <form action="{{ route('admin.about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- ✅ Wajib biar sesuai dengan route update --}}

        <div class="mb-4">
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="title" class="w-full border p-2 rounded"
                value="{{ old('title', $about->title ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description', $about->description ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Misi Kami</label>
            <textarea name="mission" rows="4" class="w-full border p-2 rounded">{{ old('mission', $about->mission ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Kenapa Seilmu?</label>
            <textarea name="why" rows="4" class="w-full border p-2 rounded">{{ old('why', $about->why ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Tagline</label>
            <input type="text" name="tagline" class="w-full border p-2 rounded"
                value="{{ old('tagline', $about->tagline ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Gambar</label>
            <input type="file" name="image">
            @if($about && $about->image)
                <img src="{{ asset('storage/' . $about->image) }}" class="h-24 mt-2 rounded shadow">
            @endif
        </div>

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>
@endsection
