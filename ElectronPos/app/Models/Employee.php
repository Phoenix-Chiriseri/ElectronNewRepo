<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['user_id','name', 'login_pin', 'pos_username', 'email','role'];

    public function isManager()
    {
        // Assuming 'role' is a column in the employees table
        return $this->role === 'manager';
    }

    public function isCashier()
    {
        // Assuming 'role' is a column in the employees table
        return $this->role === 'cashier';
    }
}
