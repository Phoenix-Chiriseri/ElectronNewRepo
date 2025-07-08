<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $table = "quote_items";
    protected $fillable = [
        'product_name',
        'measurement',
        'quantity',
        'unit_cost',
        'total_cost',
        // Add other attributes as needed
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_item_id');
    }
}
