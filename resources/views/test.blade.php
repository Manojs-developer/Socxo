<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
            Dashboard
        </h2>
    </x-slot>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">

                <!-- SIDEBAR -->
                <div class="col-3 bg-dark text-white p-3" style="height:100vh;">
                    <form method="POST" action="{{ url('/new-chat') }}">
                        @csrf
                        <button class="btn btn-light w-100 mb-3">+ New Chat</button>
                    </form>

                    <div class="list-group">
                        @foreach ($chatList as $chat)
                            <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                class="list-group-item list-group-item-action
       {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}">
                                {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                            </a>
                        @endforeach


                    </div>
                </div>

                <!-- CHAT AREA -->
                <div class="col-9">
                    <div class="chat-body" id="chatBody">
                        @foreach ($messages as $msg)
                            <div class="{{ $msg->sender === 'user' ? 'message-user' : 'message-bot' }}">
                                <div class="message-box {{ $msg->sender }}">
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="chat-footer">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control">
                            <button class="btn btn-primary" id="sendBtn">Send</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            $('#sendBtn').click(function() {
                sendMessage();
            });

            $('#messageInput').keypress(function(e) {
                if (e.which === 13) {
                    sendMessage();
                }
            });

            function sendMessage() {
                let message = $('#messageInput').val().trim();
                if (message === '') return;

                $('#chatBody').append(`
            <div class="message-user">
                <div class="message-box user">${message}</div>
            </div>
        `);

                $('#messageInput').val('');
                $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);

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
                    <div class="message-bot">
                        <div class="message-box bot">${res.reply}</div>
                    </div>
                `);

                        $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
                    }
                });
            }
        </script>

    </body>

    </html>
