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
            'email' => 'admin@material.com',
            'password' => Hash::make('secret')
        ]);

        User::factory()->create([
            'name' => 'itai',
            'email' => 'itaineilchiriseri@gmail.com',
            'password' => Hash::make('mygodisgood')
        ]);
    }
}
