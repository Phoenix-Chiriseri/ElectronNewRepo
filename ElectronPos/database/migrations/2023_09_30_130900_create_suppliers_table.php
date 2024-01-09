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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('code');
            $table->unsignedBigInteger('user_id');
            $table->string('supplier_taxnumber')->unique();
            $table->string('supplier_city')->unique();
            $table->string('supplier_address')->unique();
            $table->string('supplier_phonenumber')->unique();
            $table->string('supplier_status');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
