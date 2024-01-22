<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GRV extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'shop_id',
        'grn_date',
        'payment_method',
        'additional_information',
        'supplier_invoicenumber',
        'additional_costs',
    ];
}
