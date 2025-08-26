@extends('layouts.user')

@section('content')

<a href="{{ route('user.dashboard') }}">
    ← Kembali ke Dashboard
</a>

<div>
    <div>
        <!-- Header -->
        <div>
            <span>Chat dengan Admin</span>
        </div>

        <!-- Quick Buttons -->
        <div>
            <button onclick="askChatbot('Bagaimana status pesanan saya?')">Status Pesanan</button>
            <button onclick="askChatbot('Bagaimana cara membayar?')">Pembayaran</button>
            <button onclick="askChatbot('Bagaimana cara menghubungi admin?')">Kontak</button>
            <button onclick="askChatbot('Ada promo?')">Promo</button>
        </div>

        <!-- Messages -->
        <div id="chat-box">
            @forelse ($messages as $msg)
                <div>
                    <div>{{ $msg->message }}</div>
                    <div>{{ $msg->created_at->format('H:i') }}</div>
                </div>
            @empty
                <p>Belum ada pesan.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('chat.send') }}">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">
            <input type="text" name="message" placeholder="Ketik pesan..." required>
            <button type="submit">Kirim</button>
        </form>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

    function askChatbot(question) {
        const userBubble = document.createElement('div');
        userBubble.innerHTML = `<div>${question}</div>`;
        chatBox.appendChild(userBubble);

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
            botBubble.innerHTML = `<div>${data.answer}</div>`;
            chatBox.appendChild(botBubble);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }
</script>

@endsection
