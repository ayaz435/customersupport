<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'reason';

    protected $fillable = [
        'date', 'time', 'team', 'user', 'message', 'late_reply', 'reason',
    ];
}
