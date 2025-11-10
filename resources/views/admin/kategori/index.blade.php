@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Book Categories</h2>
        <p class="text-gray-600">Manage book categories easily: add, edit, or delete as needed.</p>
    </div>

    <!-- Actions Bar -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            ← Back to Dashboard
        </a>

        <form method="GET" action="{{ route('admin.kategori.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                   class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-200">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Search
            </button>
        </form>

        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2">
                <input type="checkbox" id="toggleGambar" checked class="rounded">
                <span class="text-sm">Show Images</span>
            </label>

            <span class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">
                Total: {{ $kategoris->total() }} Categories
            </span>

            <a href="{{ route('admin.kategori.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Category
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                    <th class="kolom-gambar px-6 py-3 text-left text-sm font-semibold text-gray-900">Image</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($kategoris as $index => $kategori)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-900">{{ $kategoris->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $kategori->nama }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $kategori->deskripsi ?? '—' }}</td>
                        <td class="kolom-gambar px-6 py-4">
                            @if (!empty($kategori->foto))
                                <img src="{{ asset('storage/' . $kategori->foto) }}"
                                     alt="{{ $kategori->nama }}"
                                     class="w-20 h-20 object-cover rounded border">
                            @else
                                <span class="text-gray-400 italic text-sm">No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Edit
                                </a>

                                @if ($kategori->bukus_count == 0)
                                    <form id="delete-form-{{ $kategori->id }}"
                                          action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                          method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                                onclick="confirmDelete({{ $kategori->id }})">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                            class="px-3 py-1 bg-gray-300 text-gray-500 rounded cursor-not-allowed text-sm" disabled>
                                        Can't Delete
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $kategoris->appends(['search' => request('search')])->links('pagination::tailwind') }}
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This category will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#3b82f6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    document.getElementById("toggleGambar").addEventListener("change", function() {
        const display = this.checked ? "" : "none";
        document.querySelectorAll(".kolom-gambar").forEach(el => {
            el.style.display = display;
        });
    });

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Failed!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    @endif
</script>
@endsection

