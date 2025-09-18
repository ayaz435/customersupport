<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersQuestion extends Model
{
    // protected $connection = 'customersupport'; // Specify the database connection
    protected $table = 'users_questions'; // Specify the table name

    protected $fillable = [
        'question',
        'name', // Add other fillable fields if needed
    ];
}