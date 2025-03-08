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
        Schema::create('gift_event', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('code')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('point')->default(1);
            $table->integer('quantity')->default(1);
            $table->boolean('active')->default(1);
            $table->longText('description')->nullable();
            $table->timestamps();
        });
        Schema::create('exchange_gift_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('gift_id');
            $table->string('name_gift')->nullable();
            $table->string('image_gift')->nullable();
            $table->string('code_gift')->nullable();
            $table->string('barcode_gift')->nullable();
            $table->integer('point')->default(1);
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Wait; 2: Confirm; 3: Cancel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_event');
        Schema::dropIfExists('exchange_gift_event');
    }
};
