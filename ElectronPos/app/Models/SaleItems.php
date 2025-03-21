<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity'];

    public function items()
{
    return $this->hasMany(SaleItem::class);
}

}
