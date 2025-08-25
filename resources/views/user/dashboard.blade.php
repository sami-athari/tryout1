@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-blue-400">
            📚 Selamat Datang di <span class="text-yellow-400">ReadHaus</span>
        </h1>
        <p class="text-blue-200 mt-2 text-lg">Temukan buku favoritmu dengan berbagai kategori menarik.</p>
    </div>

    {{-- Daftar Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($produk as $item)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden flex flex-col" data-stok="{{ $item->stok }}" data-id="{{ $item->id }}">
                <img 
                    src="{{ asset('storage/' . $item->foto) }}" 
                    alt="{{ $item->nama }}"
                    class="w-full h-72 object-cover"
                >
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $item->nama }}</h3>
                        <p class="text-sm text-gray-500">
                            Kategori: 
                            <span class="text-gray-700 font-medium">{{ $item->kategori ? $item->kategori->nama : '-' }}</span>
                        </p>
                        <p class="text-blue-600 font-bold mt-2 mb-1">Rp {{ number_format($item->harga,0,',','.') }}</p>

                        {{-- Stok --}}
                        <p class="text-sm font-medium stok-text {{ $item->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            Stok tersedia: {{ $item->stok }}
                        </p>
                    </div>

                    {{-- Form tambah ke keranjang --}}
                    @if($item->stok > 0)
                        <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-4 add-to-cart-form">
                            @csrf
                            <div class="flex items-center gap-2 mb-3">
                                <label class="text-sm text-gray-700">Jumlah:</label>
                                <div class="flex items-center border rounded-full overflow-hidden">
                                    {{-- Minus --}}
                                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold minus-btn">−</button>
                                    {{-- Input jumlah --}}
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}" class="w-16 px-2 py-2 border-0 text-center focus:ring-0 text-black qty-input" readonly>
                                    {{-- Plus --}}
                                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold plus-btn">+</button>
                                </div>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm flex items-center gap-2 w-full justify-center transition">
                                🛒 Tambahkan ke Keranjang
                            </button>
                        </form>
                    @else
                        <p class="mt-4 text-red-500 font-semibold text-center">Stok Habis</p>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-blue-200 col-span-full text-center">Tidak ada buku ditemukan.</p>
        @endforelse
    </div>
</div>

<script>
    // Plus-Minus
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const container = this.closest('[data-id]');
            const input = container.querySelector('.qty-input');
            let current = parseInt(input.value);
            if(current > 1){
                input.value = current - 1;

                // Update stok sementara
                const stokElem = container.querySelector('.stok-text');
                const stok = parseInt(container.dataset.stok);
                stokElem.textContent = 'Stok tersedia: ' + (stok - (current-1));
                stokElem.className = 'text-sm font-medium stok-text ' + ((stok - (current-1)) > 0 ? 'text-green-600' : 'text-red-600');
            }
        });
    });

    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const container = this.closest('[data-id]');
            const input = container.querySelector('.qty-input');
            let current = parseInt(input.value);
            const stok = parseInt(container.dataset.stok);

            if(current < stok){
                input.value = current + 1;

                // Update stok sementara
                const stokElem = container.querySelector('.stok-text');
                stokElem.textContent = 'Stok tersedia: ' + (stok - (current+1));
                stokElem.className = 'text-sm font-medium stok-text ' + ((stok - (current+1)) > 0 ? 'text-green-600' : 'text-red-600');
            } else {
                // Jika melebihi stok, beri notif
                Swal.fire({
                    title: 'Stok Tidak Cukup!',
                    text: 'Jumlah yang kamu pilih melebihi stok yang tersedia.',
                    icon: 'warning',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    });

    // Validasi sebelum submit
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e){
            const input = this.querySelector('.qty-input');
            const jumlah = parseInt(input.value);
            const stok = parseInt(this.closest('[data-id]').dataset.stok);

            if(jumlah < 1 || jumlah > stok){
                e.preventDefault();
                Swal.fire({
                    title: 'Jumlah Tidak Valid!',
                    text: 'Jumlah yang kamu pilih melebihi stok yang tersedia.',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
</script>
@endsection
