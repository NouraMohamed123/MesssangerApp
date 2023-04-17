<?php

namespace App\Models;

use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function partisipants()
    {
        return $this->belongsToMany(User::class, 'participants')->withPivot([
            'role',
            'joined_at',
        ]);
    }
    public function messages()
    {
        return $this->hasMany(
            Message::class,
            'conversation_id',
            'id'
        )->latest();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id', 'id');
    }
}
