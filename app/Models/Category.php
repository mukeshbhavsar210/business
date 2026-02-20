<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    protected $fillable = [ 'category_name', 'category_slug',  'showHome', 'menuOrder', 'image', 'status'];

    public function sub_category(){
        return $this->hasMany(SubCategory::class);
    }

    public function subCategories() {
        return $this->hasMany(SubCategory::class, 'category_id'); 
    }

}
