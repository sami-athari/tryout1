@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Gallery / Image -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl p-4 shadow">
                <img id="mainImage" src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                     class="w-full h-96 object-contain rounded-lg bg-gray-50 p-6">
                {{-- small thumbnails (jika kamu simpan lebih dari 1, sesuaikan) --}}
                <div class="mt-4 flex gap-3">
                    <button type="button" onclick="changeImage('{{ asset('storage/' . $produk->foto) }}')"
                            class="w-20 h-20 rounded-md overflow-hidden border">
                        <img src="{{ asset('storage/' . $produk->foto) }}" class="w-full h-full object-cover">
                    </button>
                </div>
            </div>
        </div>

        <!-- Info utama -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 shadow">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-blue-900">{{ $produk->nama }}</h1>
                        <p class="text-sm text-gray-500 mt-2">
                            @if($produk->kategori)
                                Kategori: <span class="font-medium text-gray-700">{{ $produk->kategori->nama }}</span>
                            @endif
                        </p>

                        <div class="mt-6">
                            <div class="text-3xl font-bold text-blue-900">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Panel aksi (stok, qty, add to cart) -->
                    <div class="w-full md:w-96">
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <div class="text-sm text-gray-600">Stok</div>
                                @if($produk->stok > 0)
                                    <div class="text-green-600 font-semibold">{{ $produk->stok }} tersedia</div>
                                @else
                                    <div class="text-red-500 font-semibold">Habis</div>
                                @endif
                            </div>

                            {{-- quantity --}}
                            <div class="flex items-center gap-3 mb-4">
                                <button id="decBtn" type="button"
                                        class="px-3 py-1 rounded border bg-white" aria-label="kurangi">−</button>
                                <input id="qtyInput" type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}"
                                       class="w-20 text-center border rounded px-3 py-1" />
                                <button id="incBtn" type="button"
                                        class="px-3 py-1 rounded border bg-white" aria-label="tambah">+</button>
                                <div class="ml-auto text-sm text-gray-500">Maks: {{ $produk->stok }}</div>
                            </div>

                            {{-- form add to cart --}}
                            <form action="{{ route('user.cart.add', $produk->id) }}" method="POST" id="addCartForm">
                                @csrf
                                <input type="hidden" name="jumlah" id="hiddenJumlah" value="1">
                                @if($produk->stok > 0)
                                    <button id="addCartBtn" type="submit"
                                            class="w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold transition">
                                        + Masukkan ke Keranjang
                                    </button>
                                @else
                                    <button type="button" disabled
                                            class="w-full bg-gray-300 text-gray-600 py-2 rounded-lg font-semibold">
                                        Stok Habis
                                    </button>
                                @endif
                            </form>
                        </div>

                        {{-- related --}}
                        @if($related->isNotEmpty())
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Produk Serupa</h4>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($related as $r)
                                    <a href="{{ route('user.produk.show', $r->id) }}" class="block bg-white p-2 rounded shadow-sm">
                                        <img src="{{ asset('storage/' . $r->foto) }}" alt="{{ $r->nama }}" class="w-full h-24 object-cover rounded">
                                        <div class="text-sm font-medium text-gray-800 mt-1">{{ \Illuminate\Support\Str::limit($r->nama, 30) }}</div>
                                        <div class="text-xs text-gray-500">Rp {{ number_format($r->harga,0,',','.') }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Tombol Back -->
            <div class="mt-8">
                <a href="{{ route('user.dashboard') }}"
                   class="inline-block bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 rounded-lg font-semibold transition">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

{{-- small scripts --}}
<script>
    function changeImage(url) {
        document.getElementById('mainImage').src = url;
    }

    // quantity control
    const incBtn = document.getElementById('incBtn');
    const decBtn = document.getElementById('decBtn');
    const qtyInput = document.getElementById('qtyInput');
    const hiddenJumlah = document.getElementById('hiddenJumlah');
    const maxStock = parseInt(qtyInput.max || 0);

    function setQty(val) {
        let v = parseInt(val) || 1;
        if (v < 1) v = 1;
        if (maxStock && v > maxStock) v = maxStock;
        qtyInput.value = v;
        hiddenJumlah.value = v;
    }

    incBtn && incBtn.addEventListener('click', function(){
        setQty(parseInt(qtyInput.value) + 1);
    });
    decBtn && decBtn.addEventListener('click', function(){
        setQty(parseInt(qtyInput.value) - 1);
    });
    qtyInput && qtyInput.addEventListener('input', function(){
        setQty(this.value);
    });
</script>

@endsection
