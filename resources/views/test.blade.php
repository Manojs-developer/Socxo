<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
            Dashboard
        </h2> --}}
    </x-slot>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- custom styles --}}
    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Layout */
        .app-wrapper {
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            background: #cdcecf;
            height: 100vh;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-scroll {
            overflow-y: auto;
            flex: 1;
            padding-right: 5px;
        }

        /* Prevent body scroll */


        .sidebar .list-group-item {
            background: transparent;
            color: #212529;
            border: none;
            margin-bottom: 5px;
            border-radius: 6px;
        }

        .sidebar .list-group-item.active {
            background: #5c5d63;
            color: #fff;
        }

        /* Chat Area */
        .chat-area {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #ffffff;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f7f7f8;
        }

        /* Messages */
        .message {
            display: flex;
            margin-bottom: 15px;
        }

        .message.user {
            justify-content: flex-end;
        }

        .message.bot {
            justify-content: flex-start;
        }

        .bubble {
            padding: 12px 16px;
            border-radius: 18px;
            max-width: 70%;
            line-height: 1.5;
            font-size: 14px;
        }

        .message.user .bubble {
            background: #0d6efd;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .message.bot .bubble {
            background: #e9ecef;
            color: #000;
            border-bottom-left-radius: 4px;
        }

        /* Footer */
        .chat-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
            background: #fff;
        }

        .chat-footer input {
            border-radius: 20px;
            padding-left: 15px;
        }

        .chat-footer button {
            border-radius: 20px;
        }
    </style>
    {{-- custom styles --}}

    <div class="container-fluid app-wrapper">
        <div class="row h-100">

            <!-- Sidebar -->
            <div class="col-3 p-0">
                <div class="sidebar">
                    <form method="POST" action="{{ url('/new-chat') }}">
                        @csrf
                        <button class="btn btn-light w-100 mb-3">+ New Chat</button>
                    </form>
                    <input type="text" id="chatSearch" class="form-control mb-3" placeholder="Search Chats...">
                    <div class="sidebar-scroll">

                        <!-- TODAY -->
                        @if (count($chatGroups['today']))
                            <small class="text-secondary fw-bold d-block mb-2">Today</small>
                            <div class="list-group mb-3">
                                @foreach ($chatGroups['today'] as $chat)
                                <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                class="list-group-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}"
                                data-title="{{ strtolower($chat->message) }}">
                                    {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- YESTERDAY -->
                        @if (count($chatGroups['yesterday']))
                            <small class="text-secondary fw-bold d-block mb-2">Yesterday</small>
                            <div class="list-group mb-3">
                                @foreach ($chatGroups['yesterday'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="list-group-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- THIS MONTH -->
                        @if (count($chatGroups['this_month']))
                            <small class="text-secondary fw-bold d-block mb-2">This Month</small>
                            <div class="list-group mb-3">
                                @foreach ($chatGroups['this_month'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="list-group-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- LAST MONTH -->
                        @if (count($chatGroups['last_month']))
                            <small class="text-secondary fw-bold d-block mb-2">Last Month</small>
                            <div class="list-group">
                                @foreach ($chatGroups['last_month'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="list-group-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-9 p-0">
                <div class="chat-area">

                    <div class="chat-header">
                        Chat
                    </div>

                    <div class="chat-body" id="chatBody">
                        @foreach ($messages as $msg)
                            <div class="message {{ $msg->sender }}">
                                <div class="bubble">
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="chat-footer">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control"
                                placeholder="Type your message...">
                            <button class="btn btn-primary ms-2" id="sendBtn">Send</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    {{-- script --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function scrollBottom() {
            $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
        }
        scrollBottom();

        $('#sendBtn').click(sendMessage);

        $('#messageInput').keypress(function(e) {
            if (e.which === 13) sendMessage();
        });

        function sendMessage() {
            let message = $('#messageInput').val().trim();
            if (!message) return;

            $('#chatBody').append(`
                <div class="message user">
                    <div class="bubble">${message}</div>
                </div>
            `);

            $('#messageInput').val('');
            scrollBottom();
            $.ajax({
                url: "{{ url('/send-message') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    message: message
                },
                success: function(res) {
                    if (res.error) {
                        alert(res.error);
                        return;
                    }

                    $('#chatBody').append(`
                        <div class="message bot">
                            <div class="bubble">${res.reply}</div>
                        </div>
                    `);

                    scrollBottom();
                }
            });
        }


        
        $('#chatSearch').on('keyup', function () {
            let query = $(this).val().toLowerCase().trim();

            $('.sidebar-scroll .list-group-item').each(function () {
                let title = $(this).data('title');

                if (title.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Hide empty sections
            $('.sidebar-scroll .list-group').each(function () {
                if ($(this).find('.list-group-item:visible').length === 0) {
                    $(this).prev('small').hide();
                    $(this).hide();
                } else {
                    $(this).prev('small').show();
                    $(this).show();
                }
            });
        });
    </script>

</x-app-layout>


