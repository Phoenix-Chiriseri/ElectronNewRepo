<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cattegory extends Model
{
    use HasFactory;
    protected $fillable = [
        'cattegory_name'
    ];

     //This model groups 1 or N products
     public function products() {
        return $this->hasMany('App\Product');
    }
}
