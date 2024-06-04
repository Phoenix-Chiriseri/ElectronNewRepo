<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GRV extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'grn_date',
        'payment_method',
        'supplier_invoicenumber',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'grv_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
