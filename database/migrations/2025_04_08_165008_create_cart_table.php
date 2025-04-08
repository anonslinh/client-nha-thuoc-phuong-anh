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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->index()->nullable();
            $table->string('phone');
            $table->string('name_customer')->nullable();
            $table->string('name_product');
            $table->string('code_product');
            $table->string('image_product');
            $table->string('price');
            $table->integer('quantity')->default(1);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
