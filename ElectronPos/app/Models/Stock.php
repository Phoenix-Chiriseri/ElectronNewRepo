<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    //protected $fillable = ['product_id', 'quantity'];
    protected $fillable = [
        'product_name',
        'measurement',
        'quantity',
        'unit_cost',
        'total_cost',
        'grv_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
