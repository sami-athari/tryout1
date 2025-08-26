@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-8">
    {{-- Tombol kembali --}}
    <a href="{{ route('user.dashboard') }}"
       class="inline-flex items-center text-blue-900 hover:underline mb-6">
        ← Kembali ke Dashboard
    </a>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-900 text-white px-6 py-4 text-lg font-semibold">
            💬 Chat dengan Admin
        </div>

        <!-- Quick Buttons -->
        <div class="flex flex-wrap gap-3 px-6 py-4 bg-gray-50 border-b">
            <button onclick="askChatbot('Bagaimana status pesanan saya?')"
                class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                Status Pesanan
            </button>
            <button onclick="askChatbot('Bagaimana cara membayar?')"
                class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                Pembayaran
            </button>
            <button onclick="askChatbot('Bagaimana cara menghubungi admin?')"
                class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                Kontak
            </button>
            <button onclick="askChatbot('Ada promo?')"
                class="px-4 py-2 bg-blue-900 text-white rounded-lg text-sm hover:bg-blue-800 transition">
                Promo
            </button>
        </div>

        <!-- Messages -->
        <div id="chat-box" class="h-96 overflow-y-auto px-6 py-4 space-y-4 bg-gray-50">
            @forelse ($messages as $msg)
                <div class="flex flex-col {{ $msg->sender_id == auth()->id() ? 'items-end' : 'items-start' }}">
                    <div class="{{ $msg->sender_id == auth()->id() ? 'bg-blue-900 text-white' : 'bg-gray-200 text-gray-800' }} px-4 py-2 rounded-xl max-w-xs">
                        {{ $msg->message }}
                    </div>
                    <span class="text-xs text-gray-500 mt-1">{{ $msg->created_at->format('H:i') }}</span>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada pesan.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('chat.send') }}" class="flex items-center gap-3 border-t px-6 py-4 bg-white">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">
            <input type="text" name="message" placeholder="Ketik pesan..." required
                   class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button type="submit"
                    class="px-5 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Kirim
            </button>
        </form>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

    function askChatbot(question) {
        const userBubble = document.createElement('div');
        userBubble.className = "flex flex-col items-end";
        userBubble.innerHTML = `
            <div class="bg-blue-900 text-white px-4 py-2 rounded-xl max-w-xs">${question}</div>
            <span class="text-xs text-gray-500 mt-1">Sekarang</span>
        `;
        chatBox.appendChild(userBubble);
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
            const botBubble = document.createElement('div');
            botBubble.className = "flex flex-col items-start";
            botBubble.innerHTML = `
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl max-w-xs">${data.answer}</div>
                <span class="text-xs text-gray-500 mt-1">Sekarang</span>
            `;
            chatBox.appendChild(botBubble);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }
</script>
@endsection
