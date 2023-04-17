<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Pivot
{
    use HasFactory;

    protected $casts = [
        'joined_at' => 'datetime',
    ];
}
