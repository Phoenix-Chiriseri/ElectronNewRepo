<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;

class Cart extends Model
{
    use HasFactory;

    protected  $table = 'carts';
    protected $primaryKey = ['sale_id', 'product_id'];
    public $incrementing = false;

    protected $fillable = [
        'sale_id', 'product_id','amount', 'created'
    ];
    //This model can have one or many products
}
