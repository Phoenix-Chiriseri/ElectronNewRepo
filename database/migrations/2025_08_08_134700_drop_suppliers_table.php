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
        // First, drop foreign key constraints that reference suppliers
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });
        
        Schema::table('g_r_v_s', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });
        
        // Now drop the suppliers table
        Schema::dropIfExists('suppliers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the suppliers table
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->unsignedBigInteger('user_id');
            $table->string('supplier_tinnumber');
            $table->string('supplier_vatnumber');
            $table->string('supplier_address');
            $table->string('supplier_phonenumber');
            $table->string('supplier_contactperson');
            $table->string('supplier_contactpersonnumber');
            $table->string('type');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        
        // Recreate the foreign key constraints
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
        
        Schema::table('g_r_v_s', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }
};
