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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('password')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn(['phone_number', 'shop_id', 'password']);
        });
    }
};
