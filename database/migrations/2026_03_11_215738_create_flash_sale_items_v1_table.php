<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flash_sale_items_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('flash_sale_id')->index(); // id flash_sales_v1
            $table->unsignedBigInteger('product_id')->index();    // id product_v1

            $table->decimal('flash_price', 15, 2)->nullable();     // giá flash
            $table->integer('quantity')->nullable();              // số lượng
            $table->integer('sold')->default(0);                  // đã bán (dự phòng)

            $table->tinyInteger('status')->default(1);            // 1=active,0=off
            $table->timestamps();

            $table->unique(['flash_sale_id','product_id'], 'flash_sale_item_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sale_items_v1');
    }
};