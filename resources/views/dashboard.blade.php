<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socxo Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <div class="container-fluid app-wrapper p-0">
        <div class="row h-100 g-0">

            <!-- Sidebar -->
            <div class="col-3">
                <div class="sidebar">
                    <!-- Sidebar Header -->
                    <div class="sidebar-header">
                        <img src="https://socxo.com/wp-content/themes/socxo-custom/assets/images/socxo/socxo.png"
                            alt="logo" width="100%" style="max-width: 160px;">
                    </div>

                    <!-- Sidebar Controls -->
                    <div class="sidebar-controls">
                        <form method="POST" action="{{ url('/new-chat') }}">
                            @csrf
                            <button type="submit" class="new-chat-btn">
                                <i class="bi bi-plus-lg"></i>
                                New Chat
                            </button>
                        </form>
                        <div class="search-chats">
                            <i class="bi bi-search"></i>
                            <input type="text" id="chatSearch" placeholder="Search Chats"
                                style="border: none; background: transparent; outline: none; flex: 1; font-size: 14px;">
                        </div>
                    </div>

                    <!-- Chat List -->
                    <div class="sidebar-scroll">
                        <!-- Chats Section -->
                        <div class="chat-section-title">Chats</div>

                        <!-- TODAY -->
                        @if (count($chatGroups['today']))
                            <div class="chat-section-title">Today</div>
                            <div class="chat-group">
                                @foreach ($chatGroups['today'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="chat-list-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}"
                                        data-title="{{ strtolower($chat->message) }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- YESTERDAY -->
                        @if (count($chatGroups['yesterday']))
                            <div class="chat-section-title">Yesterday</div>
                            <div class="chat-group">
                                @foreach ($chatGroups['yesterday'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="chat-list-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}"
                                        data-title="{{ strtolower($chat->message) }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- THIS MONTH -->
                        @if (count($chatGroups['this_month']))
                            <div class="chat-section-title">This Month</div>
                            <div class="chat-group">
                                @foreach ($chatGroups['this_month'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="chat-list-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}"
                                        data-title="{{ strtolower($chat->message) }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- LAST MONTH -->
                        @if (count($chatGroups['last_month']))
                            <div class="chat-section-title">Last Month</div>
                            <div class="chat-group">
                                @foreach ($chatGroups['last_month'] as $chat)
                                    <a href="{{ url('/chat?chat=' . $chat->chat_session_id) }}"
                                        class="chat-list-item {{ $activeChat === $chat->chat_session_id ? 'active' : '' }}"
                                        data-title="{{ strtolower($chat->message) }}">
                                        {{ \Illuminate\Support\Str::limit($chat->message, 30) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar Footer -->
                    <div class="sidebar-footer">
                        <div class="user-info">

                            <span>{{ Auth::user()->name ?? 'User' }}</span>
                        </div>
                        <div class="sidebar-footer-icons">
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="icon-btn" title="Logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>

                            <!-- Settings -->
                            <button class="icon-btn" title="Settings">
                                <i class="bi bi-gear"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-9">
                <div class="chat-area">

                    <div class="chat-body" id="chatBody">
                        @foreach ($messages as $msg)
                            @if ($msg->sender == 'bot')
                                <div class="message bot">


                                    <div class="message-content">
                                        <div class="message-header">
                                            <div class="message-avatar bot-avatar">
                                                <i class="bi bi-robot"></i>
                                            </div>
                                            <span class="message-sender">Socxo Chatbot</span>
                                        </div>

                                        <div class="bubble">
                                            {{ $msg->message }}
                                        </div>

                                        <div class="message-footer">
                                            <span class="message-time">
                                                {{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y, h:i A') }}
                                            </span>

                                            <div class="message-actions">
                                                <button class="action-btn" title="Copy">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                                <button class="action-btn" title="Like">
                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                </button>
                                                <button class="action-btn" title="Dislike">
                                                    <i class="bi bi-hand-thumbs-down"></i>
                                                </button>
                                                <button class="action-btn" title="Flag">
                                                    <i class="bi bi-flag"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="message user">
                                    <div class="message-content">
                                        <div class="message-header" style="justify-content: flex-end;">
                                            <span class="message-sender">{{ Auth::user()->name ?? 'guest' }}</span>
                                        </div>
                                        <div class="bubble">
                                            <div class="bubble-header">
                                                <i class="bi bi-person-fill"></i>
                                                <span class="bubble-sender">{{ Auth::user()->name ?? 'guest' }}</span>
                                            </div>
                                            <div class="bubble-text">
                                                {{ $msg->message }}
                                            </div>
                                            <div class="bubble-time">
                                                {{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <button class="scroll-to-bottom" id="scrollToBottom">
                        <i class="bi bi-arrow-up"></i>
                    </button>

                    <div class="chat-footer">
                        <div class="input-container">
                            <div class="message-input-wrapper">
                                <textarea id="messageInput" class="message-input" placeholder="Type your message..." rows="1"></textarea>
                                <button class="send-btn" id="sendBtn">
                                    <i class="bi bi-arrow-up-circle-fill"></i>
                                </button>
                            </div>
                            <div class="input-footer">
                                <span id="charCount">0</span>/4000 characters <br>
                                Disclaimer: This app uses artificial intelligence, which may make mistakes.
                            </div>
                            <div class="input-footer" style="text-align: right">
                                Socxo Comfidential
                            </div>

                        </div>


                    </div>


                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function scrollBottom() {
            const chatBody = $('#chatBody');
            chatBody.scrollTop(chatBody[0].scrollHeight);
        }

        scrollBottom();

        // Auto-resize textarea
        $('#messageInput').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Show/hide scroll to bottom button
        $('#chatBody').on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const scrollHeight = $(this)[0].scrollHeight;
            const clientHeight = $(this).height();

            if (scrollHeight - scrollTop - clientHeight > 200) {
                $('#scrollToBottom').addClass('show');
            } else {
                $('#scrollToBottom').removeClass('show');
            }
        });

        $('#scrollToBottom').click(function() {
            scrollBottom();
        });

        $('#sendBtn').click(sendMessage);

        $('#messageInput').keypress(function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function sendMessage() {
            let message = $('#messageInput').val().trim();
            if (!message) return;

            const userName = "{{ Auth::user()->name ?? 'Raghv' }}";
            const userInitial = userName.charAt(0).toUpperCase();
            const now = new Date();
            const currentDateTime = now.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                }) + ' ' +
                now.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });

            $('#chatBody').append(`
                <div class="message user">
                    <div class="message-content">
                        <div class="bubble">
                            <div class="bubble-header">
                                 <i class="bi bi-person-fill"></i>
                                
                                <span class="bubble-sender">${userName}</span>
                            </div>
                            <div class="bubble-text">
                                ${message}
                            </div>
                            <div class="bubble-time">${currentDateTime}</div>
                        </div>
                    </div>
                </div>
            `);

            $('#messageInput').val('').css('height', 'auto');
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

                    const botNow = new Date();
                    const botDateTime = botNow.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        }) + ' ' +
                        botNow.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        });

                    $('#chatBody').append(`
                    <div class="message bot">
                        <div class="message-avatar bot-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-sender">Socxo Chatbot</span>
                               
                            </div>
                            <div class="bubble">${res.reply}</div>
                             <div class="message-footer">
                                        
                                                <span class="message-time">${botDateTime}</span>
                                        
                            <div class="message-actions">
                                
                                <button class="action-btn" title="Copy">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                                <button class="action-btn" title="Like">
                                    <i class="bi bi-hand-thumbs-up"></i>
                                </button>
                                <button class="action-btn" title="Dislike">
                                    <i class="bi bi-hand-thumbs-down"></i>
                                </button>
                                <button class="action-btn" title="Share">
                                    <i class="bi bi-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                `);

                    scrollBottom();
                }
            });
        }

        // Search functionality
        $('#chatSearch').on('keyup', function() {
            let query = $(this).val().toLowerCase().trim();

            $('.chat-list-item').each(function() {
                let title = $(this).data('title');

                if (title && title.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Hide empty sections
            $('.chat-group').each(function() {
                if ($(this).find('.chat-list-item:visible').length === 0) {
                    $(this).prev('.chat-section-title').hide();
                    $(this).hide();
                } else {
                    $(this).prev('.chat-section-title').show();
                    $(this).show();
                }
            });
        });

        // Search functionality
        $('#chatSearch').on('keyup', function() {
            let query = $(this).val().toLowerCase().trim();

            $('.chat-list-item').each(function() {
                let title = $(this).data('title');

                if (title && title.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Hide empty sections
            $('.chat-group').each(function() {
                if ($(this).find('.chat-list-item:visible').length === 0) {
                    $(this).prev('.chat-section-title').hide();
                    $(this).hide();
                } else {
                    $(this).prev('.chat-section-title').show();
                    $(this).show();
                }
            });
        });

        // Copy message functionality
        $(document).on('click', '.action-btn[title="Copy"]', function() {
            const messageText = $(this).closest('.message-content').find('.bubble').text();

            navigator.clipboard.writeText(messageText).then(function() {
                const btn = $(this);
                const originalIcon = btn.find('i').attr('class');

                btn.find('i').attr('class', 'bi bi-check2');
                btn.css('background', '#34a853');
                btn.css('color', 'white');

                setTimeout(function() {
                    btn.find('i').attr('class', originalIcon);
                    btn.css('background', '');
                    btn.css('color', '');
                }, 2000);
            }.bind(this), function(err) {
                alert('Failed to copy message');
            });
        });

        // Like functionality
        $(document).on('click', '.action-btn[title="Like"]', function() {
            const btn = $(this);
            const icon = btn.find('i');

            if (icon.hasClass('bi-hand-thumbs-up-fill')) {
                icon.removeClass('bi-hand-thumbs-up-fill').addClass('bi-hand-thumbs-up');
                btn.css('color', '');
            } else {
                icon.removeClass('bi-hand-thumbs-up').addClass('bi-hand-thumbs-up-fill');
                btn.css('color', '#1a73e8');

                // Remove dislike if active
                const dislikeBtn = btn.siblings('[title="Dislike"]');
                dislikeBtn.find('i').removeClass('bi-hand-thumbs-down-fill').addClass('bi-hand-thumbs-down');
                dislikeBtn.css('color', '');
            }
        });

        // Dislike functionality
        $(document).on('click', '.action-btn[title="Dislike"]', function() {
            const btn = $(this);
            const icon = btn.find('i');

            if (icon.hasClass('bi-hand-thumbs-down-fill')) {
                icon.removeClass('bi-hand-thumbs-down-fill').addClass('bi-hand-thumbs-down');
                btn.css('color', '');
            } else {
                icon.removeClass('bi-hand-thumbs-down').addClass('bi-hand-thumbs-down-fill');
                btn.css('color', '#ea4335');

                // Remove like if active
                const likeBtn = btn.siblings('[title="Like"]');
                likeBtn.find('i').removeClass('bi-hand-thumbs-up-fill').addClass('bi-hand-thumbs-up');
                likeBtn.css('color', '');
            }
        });

        // Share/Flag functionality
        $(document).on('click', '.action-btn[title="Share"]', function() {
            const messageText = $(this).closest('.message-content').find('.bubble').text();

            if (navigator.share) {
                navigator.share({
                    title: 'Socxo Chatbot Message',
                    text: messageText
                }).then(() => {
                    console.log('Message shared successfully');
                }).catch((error) => {
                    console.log('Error sharing:', error);
                });
            } else {
                // Fallback: copy link or show share options
                navigator.clipboard.writeText(messageText).then(function() {
                    alert('Message copied to clipboard!');
                }, function(err) {
                    alert('Failed to copy message');
                });
            }
        });

        const textarea = document.getElementById('messageInput');
        const charCount = document.getElementById('charCount');
        const sendBtn = document.getElementById('sendBtn');

        const MAX_CHARS = 4000;

        textarea.addEventListener('input', function() {
            let length = textarea.value.length;

            // Prevent typing more than 4000 chars
            if (length > MAX_CHARS) {
                textarea.value = textarea.value.substring(0, MAX_CHARS);
                length = MAX_CHARS;
            }

            // Update character count
            charCount.textContent = length;

            // Disable send button if limit reached
            sendBtn.disabled = length === 0 || length >= MAX_CHARS;

            // Optional: change button style when disabled
            sendBtn.style.opacity = sendBtn.disabled ? '0.5' : '1';
            sendBtn.style.cursor = sendBtn.disabled ? 'not-allowed' : 'pointer';
        });
    </script>
    </body>

</html>
