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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->float('total');
            $table->unsignedBigInteger('rfc');
            $table->unsignedBigInteger('user_id'); // Assuming 'user_id' is the correct foreign key
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Assuming 'user_id' is the correct column to reference in the 'users' table
            $table->foreign('rfc')->references('id')->on('customers'); // Assuming 'id' is the correct column to reference in the 'customers' table
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
