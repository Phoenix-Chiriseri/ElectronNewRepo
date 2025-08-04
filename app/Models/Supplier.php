<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'supplier_address',
        'supplier_phonenumber',
        'supplier_tinnumber',
        'supplier_vatnumber',
        'user_id',
        'supplier_status',
        'supplier_contactperson',
        'supplier_contactpersonnumber',
        'type'
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id');
    }
}

