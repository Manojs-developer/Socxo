<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(Request $request)
    {

        $userId = auth()->id();

        if ($request->has('chat')) {
            session(['chat_session_id' => $request->chat]);
        }

        if (! session()->has('chat_session_id')) {
            session(['chat_session_id' => (string) Str::uuid()]);
        }

        $activeChat = session('chat_session_id');
        
        //  Sidebar Chat List, Ordered by latest activity   
        $chatList = Message::select(
            'messages.chat_session_id',
            'messages.message',
            'messages.created_at'
        )
            ->where('messages.user_id', $userId)
            ->where('messages.sender', 'user')
            ->join(
                DB::raw('(
                SELECT chat_session_id, MIN(id) AS first_id
                FROM messages
                WHERE sender = "user"
                GROUP BY chat_session_id
            ) AS first_messages'),
                function ($join) {
                    $join->on('messages.id', '=', 'first_messages.first_id');
                }
            )
            ->orderByDesc('messages.created_at')
            ->get();

        $chatGroups = [
            'today' => [],
            'yesterday' => [],
            'this_month' => [],
            'last_month' => [],
        ];

        $today = Carbon::now()->startOfDay();
        $yesterday = Carbon::now()->subDay()->startOfDay();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        foreach ($chatList as $chat) {
            $createdAt = Carbon::parse($chat->created_at);

            if ($createdAt->gte($today)) {
                $chatGroups['today'][] = $chat;
            } elseif ($createdAt->gte($yesterday) && $createdAt->lt($today)) {
                $chatGroups['yesterday'][] = $chat;
            } elseif ($createdAt->gte($thisMonth)) {
                $chatGroups['this_month'][] = $chat;
            } elseif ($createdAt->gte($lastMonth)) {
                $chatGroups['last_month'][] = $chat;
            }
        }

        //  Active Chat Messages

        $messages = Message::where('user_id', $userId)
            ->where('chat_session_id', $activeChat)
            ->orderBy('created_at')
            ->get();

        return view('dashboard', compact(
            'messages',
            'chatGroups',
            'activeChat'
        ));
    }

    public function newChat()
    {
        session(['chat_session_id' => (string) Str::uuid()]);

        return redirect('/chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
        ]);

        $userId = auth()->id();
        $message = $request->message;
        $chatSessionId = session('chat_session_id');

        // Token limit per chat
        $totalTokens = Message::where('user_id', $userId)
            ->where('chat_session_id', $chatSessionId)
            ->sum('tokens_used');

        if ($totalTokens >= 20000) {
            return response()->json([
                'error' => 'Token limit (20,000) reached. Please start a new chat.',
            ]);
        }

        // Save user message
        Message::create([
            'user_id' => $userId,
            'chat_session_id' => $chatSessionId,
            'message' => $message,
            'sender' => 'user',
            'tokens_used' => strlen($message),
        ]);

        // AI call
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $message]],
                'max_tokens' => 500,
            ]);

        $reply = $response['choices'][0]['message']['content'] ?? 'No response';

        // Save bot message
        Message::create([
            'user_id' => $userId,
            'chat_session_id' => $chatSessionId,
            'message' => $reply,
            'sender' => 'bot',
            'tokens_used' => strlen($reply),
        ]);

        return response()->json(['reply' => $reply]);
    }

    // private function getChatSessionId()
    // {
    //     if (! session()->has('chat_session_id')) {
    //         session(['chat_session_id' => (string) Str::uuid()]);
    //     }

    //     return session('chat_session_id');
    
    // }
}
