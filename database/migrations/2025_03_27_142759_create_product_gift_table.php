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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image');
            $table->string('code');
            $table->integer('point');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('trademark')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        Schema::create('product_gift', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('gifts_id')->constrained('gifts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_gift');
    }
};
