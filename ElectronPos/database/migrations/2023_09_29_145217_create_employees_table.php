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
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('password');
            $table->string('confirm_password')->unique();
            $table->string('access_level');
            $table->string('role');
            $table->foreign('user_id')->references('id')->on('users');
            $table->rememberToken();
            $table->timestamps();
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
