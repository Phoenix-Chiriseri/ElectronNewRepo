<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming a one-to-one relationship with users
            $table->string('name');
            $table->string('login_pin');
            $table->string('pos_username');
            $table->string('email')->unique();
            $table->timestamps();
            // Define foreign key constraint with users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    } 
    /**
     * Reverse the migrations.
     */
    
     public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
