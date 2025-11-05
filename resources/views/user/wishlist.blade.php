@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">💖 Wishlist Kamu</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    @if($wishlist->isEmpty())
        <p class="text-gray-600 text-center mt-10">Kamu belum menambahkan produk ke wishlist 💭</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlist as $item)
                <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition relative">
                    <img src="{{ asset('images/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}"
                         class="w-full h-48 object-cover rounded-lg mb-3">

                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $item->produk->nama }}</h3>
                    <p class="text-gray-600 mt-1 mb-3">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('user.cart') }}"
                           class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                           + Keranjang
                        </a>

                        <form action="{{ route('user.wishlist.remove', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus produk ini dari wishlist?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:text-red-800 font-semibold text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
