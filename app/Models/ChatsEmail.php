<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatsEmail extends Model
{
    use HasFactory;
    protected $fillable = ['teammember', 'user','emaillink'];
}
