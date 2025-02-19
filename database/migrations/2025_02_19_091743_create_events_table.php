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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('images');
            $table->date('time_start');
            $table->date('time_end');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        Schema::create('products_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('events_id');
            $table->string('product_id');
            $table->string('product_code');
            $table->string('name');
            $table->string('images');
            $table->string('base_price');
            $table->string('price');
            $table->integer('point');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('products_event');
    }
};
