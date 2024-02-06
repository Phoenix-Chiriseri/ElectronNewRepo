<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'email',
        'shop_address',
        'phone_number',
        'shop_city',
        'user_id'
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'shop_id');
    }
}
