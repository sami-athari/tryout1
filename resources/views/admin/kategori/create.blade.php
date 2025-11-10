@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Category</h1>

        <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="nama" id="nama"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200 @error('nama') border-red-500 @enderror"
                       placeholder="Enter category name" required>
                @error('nama')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200 @error('deskripsi') border-red-500 @enderror"
                          placeholder="Category description..."></textarea>
                @error('deskripsi')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="foto" class="block font-medium text-gray-700 mb-1">Category Image</label>
                <input type="file" name="foto" id="foto"
                       class="w-full border rounded-lg px-4 py-2 @error('foto') border-red-500 @enderror"
                       accept="image/*" required>
                @error('foto')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.kategori.index') }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

