<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectform extends Model
{
protected $fillable = [
        'form_identifier',
        'cname',
        'cpname',
        'ppname',
        'nic',
        'ntn',
        'project',
        'email',
        'web',
        'phone',
        'mobile',
        'address',
        'catagory',
        'cpabout',
        'color',
        // Add _token here
        // Add other fields as needed
    ];
    use HasFactory;
}
