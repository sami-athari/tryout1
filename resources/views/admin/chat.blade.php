@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 mb-4 inline-block">
        ← Back to Dashboard
    </a>

    <style>
        .chat-container {
            height: 75vh;
            display: flex;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .sidebar {
            width: 25%;
            background: white;
            border-right: 1px solid #e5e7eb;
            padding: 1rem;
            overflow-y: auto;
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 1rem;
            color: #1f2937;
        }

        .user-link {
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            color: #374151;
            margin-bottom: 0.25rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .user-link.active {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .user-link:hover {
            background-color: #f3f4f6;
        }

        .user-link.active:hover {
            background-color: #2563eb;
        }

        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .chat-header {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
            padding: 1rem;
            font-weight: 600;
        }

        .chat-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .chat-bubble {
            padding: 0.75rem 1rem;
            border-radius: 16px;
            max-width: 65%;
            word-wrap: break-word;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .from-admin {
            background-color: #3b82f6;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .from-user {
            background-color: #e5e7eb;
            color: #1f2937;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .chat-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 3px;
            text-align: right;
        }

        .chat-form {
            display: flex;
            padding: 0.75rem 1rem;
            gap: 0.5rem;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .chat-form input[type="text"] {
            flex: 1;
            padding: 0.5rem 1rem;
            border-radius: 24px;
            border: 1px solid #d1d5db;
            outline: none;
        }

        .chat-form input[type="text"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .chat-form button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 24px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .chat-form button:hover {
            background-color: #2563eb;
        }

        .dark-mode .chat-container { background: #2a2a2a; border-color: #3a3a3a; }
        .dark-mode .sidebar { background: #1f1f1f; border-color: #3a3a3a; }
        .dark-mode .sidebar h4 { color: #e5e5e5; }
        .dark-mode .user-link { color: #d4d4d4; }
        .dark-mode .user-link:hover { background: #2f2f2f; }
        .dark-mode .chat-area { background: #2a2a2a; }
        .dark-mode .chat-header { background: #1f1f1f; border-color: #3a3a3a; color: #e5e5e5; }
        .dark-mode .from-user { background: #3a3a3a; color: #e5e5e5; }
        .dark-mode .chat-form { background: #1f1f1f; border-color: #3a3a3a; }
        .dark-mode .chat-form input { background: #2a2a2a; color: #e5e5e5; border-color: #3a3a3a; }
    </style>

    <div class="chat-container">
        <div class="sidebar">
            <h4>Users</h4>
            @foreach($users as $u)
                <a href="{{ route('chat.index', ['user_id' => $u->id]) }}"
                   class="user-link {{ request('user_id') == $u->id ? 'active' : '' }}">
                    {{ $u->name }}
                </a>
            @endforeach
        </div>

        <div class="chat-area">
            @if ($selectedUser)
                <div class="chat-header">Chat with {{ $selectedUser->name }}</div>

                <div class="chat-messages" id="chat-box">
                    @forelse($messages as $msg)
                        <div class="chat-bubble {{ $msg->sender_id == auth()->id() ? 'from-admin' : 'from-user' }}">
                            <div>{{ $msg->message }}</div>
                            <div class="chat-time">{{ $msg->created_at->format('H:i') }}</div>
                        </div>
                    @empty
                        <p class="text-gray-500">No messages yet.</p>
                    @endforelse
                </div>

                <form action="{{ route('chat.send') }}" method="POST" class="chat-form">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                    <input type="text" name="message" placeholder="Type a message..." required>
                    <button type="submit">Send</button>
                </form>
            @else
                <div class="flex items-center justify-center h-full text-gray-500">
                    <p>Select a user from the left to start chatting.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection

