<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = [ 'user_id', 'subtotal', 'shipping', 'coupon_code', 'coupon_code_id', 'discount',
                            'grandtotal', 'payment_status', 'status', 'shipped_date', 'name', 'mobile',
                            'state_id', 'address', 'locality', 'city', 'zip', 'mobile',
    ];

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
