<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = "purchase_orders";

    protected $fillable = [
        'supplier_id',
        'shop_id',
        'purchaseorder_date',
        'payment_method',
        'expected_date',
        'delivery_instructions',
        'supplier_invoicenumber',
        'total',
    ];

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
