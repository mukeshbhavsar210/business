<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = [ 'user_id', 'product_id', 'product_variant_id', 'customer_address_id', 'subtotal', 'grandtotal', 'shipping', 'coupon_code', 'coupon_code_id', 'discount',
                            'grandtotal', 'payment_status', 'payment_method', 'cancel_reason', 'cancel_comments', 'cancelled_at', 'shipped_date', 
                            
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

    public function scopeWithFullRelations($query) {
        return $query->with([
            'user',
            'items',
            'orderItems.product.images',
            'orderItems.product.size',
            'orderItems.product.color'
        ]);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function address() {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }

    public function statusHistories() {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function latestStatus() {        
        return $this->hasOne(OrderStatusHistory::class)->latestOfMany('created_at');
    }   

    // public function latestStatus() {
    //     return $this->hasOne(OrderStatusHistory::class)->latestOfMany('date');
    // }
}