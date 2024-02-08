<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'supplier_name',
        'suplier_address',
        'supplier_phonenumber',
        'supplier_taxnumber',
        'supplier_city',
        'supplier_address',
        'supplier_phonenumber',
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

