<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details'; 
    protected $fillable = ['chat_app_last_login_at', 'chat_app_last_logout_at','chat_app_last_active_at','chat_app_last_left_at',
            'chat_app_last_visited_url','chat_web_last_login_at','chat_web_last_logout_at','chat_web_last_active_at',
            'chat_web_last_left_at','chat_web_last_visited_url', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}