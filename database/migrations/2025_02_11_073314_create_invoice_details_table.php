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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->unsignedBigInteger('product_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->unsignedBigInteger('category_id');
            $table->string('category_name');
            $table->unsignedBigInteger('trade_mark_id')->nullable();
            $table->string('trade_mark_name')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 15, 4);
            $table->decimal('discount', 15, 4)->default(0);
            $table->boolean('use_point');
            $table->decimal('sub_total', 15, 4);
            $table->text('serial_numbers')->nullable();
            $table->integer('return_quantity')->default(0);
            $table->timestamps();

            // Khóa ngoại liên kết với bảng invoices
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
