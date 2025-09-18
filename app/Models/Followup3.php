<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup3 extends Model
{
    use HasFactory;
    protected $fillable = ['comunicationtype','teamstatus','adminstatus','cid','cname','phone','task','team','team_id','date','priority','detail'];
}
