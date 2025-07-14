<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printers extends Model
{
    use HasFactory;

      protected $fillable = [
        'name', 'driver_name', 'connection_mode', 'device_id', 'status'
    ];
}
