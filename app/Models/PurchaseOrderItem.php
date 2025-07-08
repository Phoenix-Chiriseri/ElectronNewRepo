<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $table = "purchase_order_item";
    protected $fillable = [
        'product_name',
        'measurement',
        'quantity',
        'unit_cost',
        'total_cost',
        // Add other attributes as needed
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
