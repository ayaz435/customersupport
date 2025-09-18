<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storedesign extends Model
{
    use HasFactory;
    protected $table = 'storedesigns'; // If your table name differs from convention
    protected $fillable = ['images', 'detail', 'design_id', 'drm_user_id', 'category_id', 'sub_category_id', 'sliders', 'main_sliders', 'status', 'user_id', 'com_id', 'cname', 'email'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
