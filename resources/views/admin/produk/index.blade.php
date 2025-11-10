@extends('layouts.admin')

@section('content')
@php
    $kategori = \App\Models\Kategori::all();
@endphp

<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Product Management</h2>
        <p class="text-gray-600">Manage your book collection — add, edit, delete, or search products quickly.</p>
    </div>

    <!-- Search & Filter -->
    <form action="{{ route('admin.produk.index') }}" method="GET" class="bg-white border rounded-lg p-4 mb-6 flex flex-col md:flex-row md:items-center gap-3">
        <div class="w-full md:w-1/4">
            <select name="kategori" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200">
                <option value="">All Categories</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ (int) request()->input('kategori') === $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                   class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Search</button>
        </div>
    </form>

    <!-- Action buttons -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">← Dashboard</a>
        <a href="{{ route('admin.produk.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Product</a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 text-red-800 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <!-- Table -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Stock</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Image</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($produk as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-900">{{ ($produk->currentPage() - 1) * $produk->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                {{ $item->kategori->nama ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($item->harga,0,',','.') }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->stok }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="h-20 w-20 object-cover rounded border mx-auto">
                            @else
                                <span class="text-gray-400 italic text-xs">No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.produk.edit', $item->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Edit</a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ $item->stok }}')" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($produk->lastPage() > 1)
        <div class="mt-6 flex justify-end items-center gap-2">
            @if ($produk->previousPageUrl())
                <a href="{{ $produk->previousPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-50">‹ Prev</a>
            @else
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">‹ Prev</span>
            @endif

            @for ($i = 1; $i <= $produk->lastPage(); $i++)
                @if ($i == $produk->currentPage())
                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-semibold">{{ $i }}</span>
                @else
                    <a href="{{ $produk->url($i) }}" class="px-3 py-1 border rounded hover:bg-gray-50">{{ $i }}</a>
                @endif
            @endfor

            @if ($produk->nextPageUrl())
                <a href="{{ $produk->nextPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-50">Next ›</a>
            @else
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">Next ›</span>
            @endif
        </div>
    @endif
</div>

<script>
    function confirmDelete(id, stok) {
        if (parseInt(stok) > 0) {
            Swal.fire({ icon:'error', title:'Cannot Delete!', text:'Product still has stock.', confirmButtonColor:'#2563eb' });
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: "This product will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#2563eb',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        });
    }
</script>
@endsection

