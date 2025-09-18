<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;
    protected $fillable = [
        'from_id', 'to_id', 'body', 'team', 'user', 'attachment', 'created_at', 'updated_at','message_type'
    ];
}
