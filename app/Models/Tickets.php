<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
            'user_id',
            'com_id',
            'team_id',
            'service_id',
            'dep_id',
            'category',
            'priority',
            'description',
            'status',
            'dep_status',
            'user_feedback',
            ];
           
    public function reviews()
    {
        return $this->hasMany(Review::class, 'complainid', 'id');
    }
        
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function handler()
    {
        return $this->belongsTo(User::class, 'handle_by');
    }
    
    public function team()
    {
        return $this->belongsTo(User::class, 'team_id');
    }
    
    
}
