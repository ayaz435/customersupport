<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateMessages extends Model
{
    use HasFactory;
    
    protected $table = 'late_messages';
    protected $fillable = [
        'message',
        'lateminutes',
        'teammember',
        'team_id',
        'user' ,
        'user_id',
        'user_message_id',
        'reason'
    ];
    
                            
}
