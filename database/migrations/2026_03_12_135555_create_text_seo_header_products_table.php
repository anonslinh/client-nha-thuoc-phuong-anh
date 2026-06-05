<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('text_seo_header_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('header_id')->index();   // text_seo_header.id
            $table->unsignedBigInteger('product_id')->index();  // product_v1.id

            $table->integer('sort_order')->default(0)->index();
            $table->tinyInteger('status')->default(1)->index();

            $table->timestamps();

            $table->unique(['header_id', 'product_id'], 'uk_text_seo_header_product');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('text_seo_header_products');
    }
};