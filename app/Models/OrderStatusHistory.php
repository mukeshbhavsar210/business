<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [ 'order_id', 'tracking_number', 'courier', 'note', 'status', 'date' ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
