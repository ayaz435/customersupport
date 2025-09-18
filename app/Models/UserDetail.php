<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'password_text'; 
    protected $fillable = ['images', 'password'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}