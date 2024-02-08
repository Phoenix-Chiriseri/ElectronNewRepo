<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('code');
            $table->unsignedBigInteger('user_id');
            $table->string('supplier_taxnumber');
            $table->string('supplier_city');
            $table->string('supplier_address');
            $table->string('supplier_phonenumber');
            $table->string('supplier_contactperson');
            $table->string('supplier_contactpersonnumber');
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
