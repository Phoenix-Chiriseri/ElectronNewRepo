<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('selling_price', 10, 2); // New column for selling price
            $table->decimal('unit_of_measurement', 10, 2);
            $table->integer('quantity');
            //Correct the foreign key definition
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('cattegories') // Use the correct table name "categories"
                  ->onDelete('cascade'); // You can set onDelete as needed
            $table->enum('product_status', ['active', 'not_active']);
            $table->timestamps();
        });
    }    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
