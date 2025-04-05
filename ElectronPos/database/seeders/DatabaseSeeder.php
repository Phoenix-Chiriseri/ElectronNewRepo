<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
            'name' => 'Admin',
            'role' =>'admin',
            'email' => 'admin@material.com',
            'email_verified_at' =>now(),
            'password' => Hash::make('secret')
        ]);

        User::factory()->create([
            'name' => 'itai',
            'role' =>  'cashier',
            'email' => 'itaineilchiriseri@gmail.com',
            'email_verified_at' =>now(),
            'password' => Hash::make('mygodisgood')
        ]);
    }
}
