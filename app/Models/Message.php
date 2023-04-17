<?php

namespace App\Models;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name ' => 'nour mohamed',
        ]);
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'recipients')->withPivot([
            'read_at',
            'deleted_at',
        ]);
    }
}
