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
        Schema::create('deal_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade'); // Deal tương ứng
            $table->integer('deal_product_id'); // Sản phẩm trong deal
            $table->integer('store_id'); // Cửa hàng có sản phẩm này
            $table->integer('stock_quantity'); // Số lượng sản phẩm có sẵn tại cửa hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_inventories');
    }
};
