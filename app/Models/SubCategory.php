<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    
    protected $table = 'sub_categories';
    protected $fillable = ['name','root_id','category_id','user_id','main_category_id'];

    // Subcategory belongs to a main category
    public function mainCategory()
    {
        return $this->belongsTo(Catagory::class, 'main_category_id');
    }
    
    //hasMany(TargetModel::class, foreign_key_on_target, local_key_on_this_model)

    public function productDesigns()
    {
        return $this->hasMany(Productdesign::class, 'category', 'category_id');
    }

}
