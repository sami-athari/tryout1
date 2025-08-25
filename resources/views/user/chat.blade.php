@extends('layouts.user')

@section('content')

<a href="{{ route('user.dashboard') }}" class="btn fw-semibold mb-3" style="background-color: #3b82f6; color: white; border-radius: 8px;">
    ← Kembali ke Dashboard
</a>

<style>
    body {
        background: linear-gradient(to bottom right, #1e3a8a, #3b82f6, #60a5fa);
        font-family: 'Inter', sans-serif;
    }
    .chat-area {
        background: #f9fafb;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        height: 75vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .chat-header {
        background: linear-gradient(to right, #1e40af, #3b82f6);
        color: white;
        padding: 1rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chat-header img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .chat-messages {
        flex: 1;
        padding: 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        background: #e0f2fe;
    }
    .chat-bubble {
        padding: 0.7rem 1rem;
        border-radius: 18px;
        margin-bottom: 10px;
        max-width: 70%;
        word-wrap: break-word;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
    }
    .from-user {
        background: #3b82f6;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 6px;
    }
    .from-admin {
        background: #ffffff;
        color: #111827;
        align-self: flex-start;
        border-bottom-left-radius: 6px;
        border: 1px solid #d1d5db;
    }
    .chat-time {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-top: 4px;
        text-align: right;
    }
    .chat-form {
        display: flex;
        padding: 0.8rem;
        gap: 0.5rem;
        background: white;
        border-top: 1px solid #e5e7eb;
    }
    .chat-form input[type="text"] {
        flex: 1;
        padding: 0.6rem 1rem;
        border-radius: 9999px;
        border: 1px solid #cbd5e1;
        outline: none;
        color: #111827; /* ⬅ teks jadi hitam */
        font-size: 1rem;
    }
    .chat-form input[type="text"]::placeholder {
        color: #6b7280; /* abu-abu agar placeholder beda dengan teks */
    }
    .chat-form input[type="text"]:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
    }
    .chat-form button {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 9999px;
        transition: 0.2s;
    }
    .chat-form button:hover {
        background: #1d4ed8;
    }
    .chatbot-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.7rem;
        background: #dbeafe;
        border-bottom: 1px solid #bfdbfe;
    }
    .chatbot-buttons button {
        background: #3b82f6;
        border: none;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: 0.2s;
    }
    .chatbot-buttons button:hover {
        background: #2563eb;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="chat-area">
        <!-- Header -->
        <div class="chat-header">
            <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" alt="Admin">
            <span>💬 Chat dengan Admin</span>
        </div>

        <!-- Quick Buttons -->
        <div class="chatbot-buttons">
            <button onclick="askChatbot('Bagaimana status pesanan saya?')">📦 Status Pesanan</button>
            <button onclick="askChatbot('Bagaimana cara membayar?')">💳 Pembayaran</button>
            <button onclick="askChatbot('Bagaimana cara menghubungi admin?')">📞 Kontak</button>
            <button onclick="askChatbot('Ada promo?')">🎁 Promo</button>
        </div>

        <!-- Messages -->
        <div class="chat-messages" id="chat-box">
            @forelse ($messages as $msg)
                <div class="chat-bubble {{ $msg->sender_id === auth()->id() ? 'from-user' : 'from-admin' }}">
                    <div>{{ $msg->message }}</div>
                    <div class="chat-time">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            @empty
                <p class="text-gray-600">Belum ada pesan.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('chat.send') }}" class="chat-form">
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
        userBubble.className = 'chat-bubble from-user';
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
            botBubble.className = 'chat-bubble from-admin';
            botBubble.innerHTML = `<div>${data.answer}</div>`;
            chatBox.appendChild(botBubble);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }
</script>

@endsection
