<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    use HasFactory, UUID;
    protected $fillable = [
    'from_id', 'to_id', 'body', 'team', 'user', 'attachment', 'created_at', 'updated_at'
    ];
    
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
