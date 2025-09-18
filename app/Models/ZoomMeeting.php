<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    protected $fillable = [
        'topic', 'start_time', 'zoom_meeting_id',
        // Add 'topic' to the fillable array
    ];
}
