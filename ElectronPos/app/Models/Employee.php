<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name', 'login_pin', 'pos_username', 'email','role'];

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
