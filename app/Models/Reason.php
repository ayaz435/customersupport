<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'reasons';

    protected $fillable = [
       'messageid', 'date', 'time', 'team', 'user', 'message', 'late_reply', 'reason',
    ];
}
