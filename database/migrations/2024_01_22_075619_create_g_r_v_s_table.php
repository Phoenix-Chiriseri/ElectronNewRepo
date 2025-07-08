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
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->date('grn_date');
            $table->string('payment_method');
            $table->string('total');
            $table->string('supplier_invoicenumber');
            $table->timestamps();
            // Foreign keys to the supplier table
           $table->foreign('supplier_id')
           ->references('id')
           ->on('suppliers')
           ->nullOnDelete(); // optional: handles what happens when a supplier is deleted
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
