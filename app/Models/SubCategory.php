<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {
    use HasFactory;

    public function subCategories() {
        return $this->hasMany(SubCategory::class, 'category_id');  
    }

    public function subSubCategories()
{
    return $this->hasMany(SubSubCategory::class, 'sub_category_id');
}
}
