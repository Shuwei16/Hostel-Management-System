<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'status'];

    public  function sender()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public  function receiver()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
