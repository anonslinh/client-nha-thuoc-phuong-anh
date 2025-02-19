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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('membership_levels_id')->nullable();
            $table->string('image')->nullable(); // Hình ảnh quà
            $table->longText('description')->nullable();
            $table->integer('discount_amount');
            $table->date('expiry_date'); // Ngày hết hạn
            $table->text('applicable_products')->nullable(); // Danh sách sản phẩm áp dụng (JSON)
            $table->integer('points_required');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
