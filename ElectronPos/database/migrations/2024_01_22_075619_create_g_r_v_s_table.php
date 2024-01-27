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
        Schema::create('g_r_v_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('shop_id'); 
            $table->date('grn_date');
            $table->string('payment_method');
            $table->string('grvNumber');
            $table->string('total');
            $table->text('additional_information');
            $table->string('supplier_invoicenumber');
            $table->timestamps();
            // Foreign keys
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g_r_v_s');
    }
};
