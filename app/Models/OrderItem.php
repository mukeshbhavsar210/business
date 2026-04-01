<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    use HasFactory;

    protected $fillable = [ 'order_id', 'product_id', 'product_variant_id', 'size_id', 'color_id', 'discount', 'coupon_code', 
                            'coupon_code_id', 'qty', 'shipping', 'price', 'discount_percent', 'discounted_price', 'subtotal', 
                            'grandtotal', 'shipping', 'discountCodeId', 'payment_status', 
                            'payment_method', 'return_days','delivery_min_days', 'delivery_max_days', ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class);
    }

    public function size() {
        return $this->belongsTo(Size::class);
    }

    public function color() {
        return $this->belongsTo(Color::class);
    }

    // public function variant() {
    //     return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    // }

    public function variant() {
        return $this->belongsTo(ProductVariant::class);
    }

    public function history() {
        return $this->belongsTo(OrderStatusHistory::class);
    }
}