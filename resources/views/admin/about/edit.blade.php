@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit About Us</h1>

        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200"
                    value="{{ old('title', $about->title ?? '') }}">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">{{ old('description', $about->description ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Mission</label>
                <textarea name="mission" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">{{ old('mission', $about->mission ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Why Seilmu?</label>
                <textarea name="why" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">{{ old('why', $about->why ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Tagline</label>
                <input type="text" name="tagline" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200"
                    value="{{ old('tagline', $about->tagline ?? '') }}">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" class="w-full border rounded-lg px-4 py-2">
                @if($about && $about->image)
                    <img src="{{ asset('storage/' . $about->image) }}" class="h-24 mt-2 rounded shadow">
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.about.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

