<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_address',
        'customer_phonenumber',
        'customer_taxnumber',
        'customer_city',
        'customer_address',
        'customer_phonenumber',
        'user_id',
        'customer_status'
    ];

    public function sales() {
        return $this->hasMany('App\Sale', 'sale_id');
    }
}
