<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleZig extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'total', 'change','amountPaid'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sale')
            ->withPivot('quantity')
            ->withTimestamps();
    }

}
