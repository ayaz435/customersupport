<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveChats extends Model
{
    use HasFactory;
    
    protected $fillable = ['teammember', 'team_id','user','user_id','chat_active_status'];

}
