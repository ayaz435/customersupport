<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details'; 
    protected $fillable = ['app_last_login_at', 'app_last_logout_at','app_last_active_at','app_last_left_at',
            'app_last_visited_url','web_last_login_at','web_last_logout_at','web_last_active_at',
            'web_last_left_at','web_last_visited_url', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
