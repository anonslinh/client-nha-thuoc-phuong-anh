<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('best_sellers_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id')->index();    // product_v1.id
            $table->decimal('sale_price', 15, 2)->nullable();     // giá sale
            $table->string('unit', 50)->nullable();               // chai/lọ/vỉ/chiếc...
            $table->integer('sort_order')->default(0)->index();   // thứ tự hiển thị
            $table->tinyInteger('status')->default(1);            // 1=on,0=off

            $table->timestamps();

            $table->unique(['product_id'], 'best_sellers_unique_product');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('best_sellers_v1');
    }
};