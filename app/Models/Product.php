<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [ 'title', 'slug', 'description', 'short_description', 'shipping_returns', 'related_products', 
        'price', 'compare_price', 'category_id', 'sub_category_id', 'brand_id', 'is_featured', 'sku', 'barcode', 
        'track_qty', 'qty', 'status', 'sub2_category_id'
    ];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class);
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

}
