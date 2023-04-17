<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Pivot
{
    use HasFactory, SoftDeletes;
}
