<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productdesign extends Model
{
    use HasFactory;
    protected $table = 'productdesigns';
    protected $fillable = ['name','cname','com_id','user_id','category','main_img','img_url','design_id','main_category_id','selected_at'];
    
    // Product design belongs to a main category
    public function mainCategory()
    {
        return $this->belongsTo(Catagory::class, 'main_category_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'category', 'category_id');
    }
}
