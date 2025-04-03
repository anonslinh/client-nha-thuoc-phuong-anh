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
        Schema::create('deal_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade'); // Thuộc về deal nào
            $table->string('sku')->unique(); // Mã sản phẩm riêng biệt trong deal
            $table->string('name'); // Tên sản phẩm
            $table->string('image')->nullable(); // Ảnh sản phẩm
            $table->text('description')->nullable(); // Thông tin mô tả sản phẩm
            $table->decimal('original_price', 10, 2); // Giá gốc
            $table->decimal('deal_price', 10, 2); // Giá ưu đãi trong deal
            $table->integer('quantity')->default(1); // Số lượng tồn trong deal
            $table->integer('display_order')->default(0); // Số lượng tồn trong deal
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_products');
    }
};
