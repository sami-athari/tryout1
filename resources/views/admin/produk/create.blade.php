@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Product</h1>

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Category</label>
                <select name="kategori_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200" required>
                    <option value="">-- Select Category --</option>
                    @foreach($kategoris as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="nama" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Price</label>
                <input type="number" name="harga" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stok" id="stok" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200" value="{{ old('stok') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Product Photo</label>
                <input type="file" name="foto" class="w-full border rounded-lg px-4 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.produk.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Errors Found',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#2563eb'
        })
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb'
        })
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: "{{ session('error') }}",
            confirmButtonColor: '#2563eb'
        })
    @endif
</script>
@endsection

