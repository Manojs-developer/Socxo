<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
protected $fillable = [
    'user_id',
    'chat_session_id',
    'message',
    'sender',
    'tokens_used'
];

}
