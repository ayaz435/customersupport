<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;
    
    protected $table = 'catagories';
    protected $fillable = ['images','com_id','user_id','email'];
    
    // One main category has many subcategories
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id')->orderBy('created_at', 'desc');
    }

    // One main category has many product designs
    public function productDesigns()
    {
        return $this->hasMany(Productdesign::class, 'main_category_id')
                ->orderBy('is_uploaded', 'desc')       // true (1) comes before false (0)
                ->orderBy('created_at', 'desc');
    }
}
