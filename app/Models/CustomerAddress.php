<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model {
    use HasFactory;
    protected $fillable = [ 'user_id', 'address_type', 'default_address', 'first_name', 'last_name', 'mobile', 'address', 'locality', 'city', 'zip', 'country_id',  ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
