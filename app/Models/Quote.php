<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = "quotes";
    protected $fillable = [
        'customer_id',
        'user_id',
        'quote_number',
        'quote_date',
        'total',
        // Add other attributes as needed
    ];


    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class, 'quote_item_id');
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
