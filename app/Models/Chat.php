<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $connection = 'chat';
    protected $table = 'ch_messages';
    protected $primaryKey = 'id';
}
