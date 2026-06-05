<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('season_disease_category_products_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->index(); // season_disease_categories_v1.id
            $table->unsignedBigInteger('product_id')->index();  // product_v1.id

            $table->decimal('sale_price', 15, 2)->nullable();
            $table->string('unit', 50)->nullable();             // chai/lọ/vỉ/chiếc...
            $table->integer('sort_order')->default(0)->index();
            $table->tinyInteger('status')->default(1)->index();

            $table->timestamps();

            $table->unique(['category_id', 'product_id'], 'uk_season_disease_product_v1');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_disease_category_products_v1');
    }
};