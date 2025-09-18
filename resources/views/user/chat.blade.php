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

      <!-- Contact Section -->
<div class="text-center py-8 bg-gray-50 border-t">
    <h3 class="text-xl font-semibold text-gray-800 mb-2">Butuh Bantuan?</h3>
    <p class="text-gray-600 mb-6">Hubungi Admin langsung melalui WhatsApp atau Email</p>

    <div class="flex justify-center gap-6">
        <!-- WhatsApp -->
        <a href="https://wa.me/6281234567890" target="_blank"
           class="flex items-center justify-center w-14 h-14 rounded-full bg-green-500 text-white hover:bg-green-600 transform hover:scale-110 transition shadow-lg">
            <!-- WhatsApp SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 32 32" fill="currentColor">
                <path d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.7 5.4 2 7.8L.5 31.5l7.9-2.1c2.3 1.2 4.9 1.8 7.6 1.8 8.6 0 15.5-6.9 15.5-15.5S24.6.5 16 .5zm0 28.1c-2.4 0-4.8-.6-6.9-1.7l-.5-.3-4.7 1.3 1.3-4.6-.3-.5c-1.3-2.2-2-4.6-2-7.1C2.9 8.5 8.8 2.6 16 2.6c7.2 0 13.1 5.9 13.1 13.1s-5.9 12.9-13.1 12.9zm7.5-9.7c-.4-.2-2.2-1.1-2.6-1.2-.3-.1-.6-.2-.8.2-.2.4-.9 1.2-1.1 1.4-.2.2-.4.3-.8.1-.4-.2-1.5-.6-2.8-1.9-1-1-1.6-2.2-1.8-2.6-.2-.4 0-.6.2-.8.2-.2.4-.4.6-.6.2-.2.3-.4.5-.6.2-.2.1-.5 0-.7-.1-.2-.8-1.9-1.1-2.6-.3-.6-.6-.5-.8-.5h-.7c-.2 0-.7.1-1.1.5-.4.4-1.5 1.4-1.5 3.5s1.5 4.1 1.7 4.4c.2.3 3 4.7 7.3 6.5.9.4 1.6.7 2.2.9.9.3 1.7.3 2.3.2.7-.1 2.2-.9 2.5-1.7.3-.8.3-1.5.2-1.7-.1-.2-.4-.3-.8-.5z"/>
            </svg>
        </a>

        <!-- Email -->
        <a href="mailto:sami.athari.z@gmail.com"
           class="flex items-center justify-center w-14 h-14 rounded-full bg-red-500 text-white hover:bg-red-600 transform hover:scale-110 transition shadow-lg">
            <!-- Email SVG (Gmail Style) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 13.065 1.5 6.75V18a2.25 2.25 0 0 0 2.25 2.25h16.5A2.25 2.25 0 0 0 22.5 18V6.75l-10.5 6.315z"/>
                <path d="M21.75 4.5H2.25a.75.75 0 0 0-.75.75v.527l10.5 6.315 10.5-6.315V5.25a.75.75 0 0 0-.75-.75z"/>
            </svg>
        </a>
    </div>
</div>


    </div>
</div>

<!-- FontAwesome untuk icon -->
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

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
