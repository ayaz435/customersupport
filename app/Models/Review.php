<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['complainid', 'manager_rating', 'team_rating', 'overall_rating', 'managerdetail', 'projectdetail', 'overalldetail', 'suggestion'];

    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'complainid', 'id');
    }
}
