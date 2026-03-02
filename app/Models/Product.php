<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [ 'title', 'slug', 'description', 'short_description', 'shipping_returns', 'related_products', 
        'price', 'compare_price', 'category_id', 'sub_category_id', 'brand_id', 'is_featured', 'sku', 'barcode', 
        'track_qty', 'qty', 'recommended', 'views', 'discount_percentage', 'average_rating', 'is_returnable', 'return_days', 
        'delivery_min_days', 'delivery_max_days', 'status', 'sub2_category_id'
    ];

    protected $appends = ['average_rating', 'rating_count'];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }    

    public function variant_images(){
        return $this->hasMany(ProductVariant::class);
    }  

    public function color() {
        return $this->belongsTo(Color::class);
    }

    public function size() {
        return $this->belongsTo(Size::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }    

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute() {
        return round($this->ratings()->avg('rating'), 1);
    }

    public function getRatingCountAttribute() {
        return $this->ratings()->count();
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function subSubCategory() {
        return $this->belongsTo(SubSubCategory::class);
    }
}