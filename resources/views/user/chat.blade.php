@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">

    {{-- Back Button --}}
    <a href="{{ route('user.dashboard') }}"
       class="inline-flex items-center text-blue-900 hover:underline mb-6">
        ← Kembali ke Dashboard
    </a>

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">

        <!-- Header -->
        <div class="bg-blue-900 text-white px-6 py-4 text-lg font-semibold">
            💬 Chat dengan Admin
        </div>

        <!-- Quick Question Buttons -->
        <div class="flex flex-wrap gap-3 px-6 py-4 bg-gray-50 border-b border-gray-200">
            @php
                $quick = [
                    'Bagaimana status pesanan saya?' => 'Status Pesanan',
                    'Bagaimana cara membayar?' => 'Pembayaran',
                    'Bagaimana cara menghubungi admin?' => 'Kontak',
                    'Ada promo?' => 'Promo'
                ];
            @endphp

            @foreach ($quick as $q => $label)
                <button
                    onclick="askChatbot('{{ $q }}')"
                    class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <!-- Messages -->
        <div id="chat-box" class="h-96 overflow-y-auto px-6 py-4 space-y-4 bg-gray-50">
            @forelse ($messages as $msg)
                <div class="flex flex-col {{ $msg->sender_id == auth()->id() ? 'items-end' : 'items-start' }}">
                    <div class="{{ $msg->sender_id == auth()->id() ? 'bg-blue-900 text-white' : 'bg-white border border-gray-200 text-gray-800' }}
                                px-4 py-2 rounded-xl max-w-xs shadow-sm">
                        {{ $msg->message }}
                    </div>
                    <span class="text-xs text-gray-500 mt-1">
                        {{ $msg->created_at->format('H:i') }}
                    </span>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada pesan.</p>
            @endforelse
        </div>

        <!-- Send Message Form -->
        <form method="POST" action="{{ route('chat.send') }}"
              class="flex items-center gap-3 border-t px-6 py-4 bg-white">
            @csrf
            <input type="hidden" name="receiver_id"
                   value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">

            <input type="text" name="message"
                   placeholder="Ketik pesan..."
                   required
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">

            <button type="submit"
                    class="px-5 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Kirim
            </button>
        </form>

        <!-- Contact Section -->
        <div class="text-center py-8 bg-gray-50 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
            <p class="text-gray-600 mb-6">Hubungi Admin melalui WhatsApp atau Email</p>

            <div class="flex justify-center gap-8">

                {{-- WhatsApp --}}
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.7 5.4 2 7.8L.5 31.5l7.9-2.1c2.3 1.2 4.9 1.8 7.6 1.8 8.6 0 15.5-6.9 15.5-15.5S24.6.5 16 .5z"/>
                    </svg>
                </a>

                {{-- Email --}}
                <a href="mailto:sami.athari.z@gmail.com"
                   class="w-12 h-12 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 13.065 1.5 6.75V18a2.25 2.25 0 0 0 2.25 2.25h16.5A2.25 2.25 0 0 0 22.5 18V6.75l-10.5 6.315z"/>
                        <path d="M21.75 4.5H2.25v.527l10.5 6.315 10.5-6.315V5.25z"/>
                    </svg>
                </a>

            </div>
        </div>

    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

    function askChatbot(question) {
        const bubble = document.createElement('div');
        bubble.className = "flex flex-col items-end";
        bubble.innerHTML = `
            <div class="bg-blue-900 text-white px-4 py-2 rounded-xl max-w-xs shadow-sm">${question}</div>
            <span class="text-xs text-gray-500 mt-1">Sekarang</span>
        `;
        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch("{{ route('chat.chatbot') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ question })
        })
        .then(res => res.json())
        .then(data => {
            const bot = document.createElement('div');
            bot.className = "flex flex-col items-start";
            bot.innerHTML = `
                <div class="bg-white border border-gray-200 text-gray-800 px-4 py-2 rounded-xl max-w-xs shadow-sm">${data.answer}</div>
                <span class="text-xs text-gray-500 mt-1">Sekarang</span>
            `;
            chatBox.appendChild(bot);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }
</script>
@endsection
