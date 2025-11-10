@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6 dark:text-white">💖 Wishlist</h2>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-200 px-4 py-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    @if($wishlist->isEmpty())
        <p class="text-center text-gray-500 dark:text-gray-400 py-10">Kamu belum menambahkan produk ke wishlist 💭</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlist as $item)
                @php
                    $produk = $item->produk;
                    $imageSrc = $produk->foto ? asset('storage/' . $produk->foto) : asset('images/placeholder.png');
                @endphp

                <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <a href="{{ route('user.produk.show', $produk->id) }}">
                        <img src="{{ $imageSrc }}" alt="{{ $produk->nama }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold mb-2 line-clamp-2 dark:text-white">{{ $produk->nama }}</h4>
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($produk->harga,0,',','.') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $produk->kategori ? $produk->kategori->nama : '-' }}</p>
                        </div>
                    </a>

                    <div class="p-4 pt-0 flex justify-between items-center">
                        <form action="{{ route('user.cart.add', $produk->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                + Cart
                            </button>
                        </form>

                        <form action="{{ route('user.wishlist.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-semibold">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
