<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'change', 'amountPaid', 'invoice_id','html'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'invoice_id');
    }
   
}
