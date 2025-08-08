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
        Schema::create('purchase_orders', function (Blueprint $table) {

    $table->id();
    $table->unsignedBigInteger('supplier_id');
    $table->date('purchaseorder_date');
    $table->string('payment_method');
    $table->date('expected_date');
    $table->text('delivery_instructions')->nullable();
    $table->string('supplier_invoicenumber')->nullable();
    $table->decimal('total', 10, 2);
    $table->string('status')->default('pending'); // pending, received, cancelled
    $table->timestamps();
    $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
