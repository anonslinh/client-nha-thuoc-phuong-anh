<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('search_keyword_products_v1', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('keyword_id')->index();  // search_keywords_v1.id
      $table->unsignedBigInteger('product_id')->index();  // product_v1.id

      $table->integer('sort_order')->default(0)->index(); // ưu tiên hiển thị
      $table->tinyInteger('status')->default(1)->index(); // 1=on,0=off (dự phòng)

      $table->timestamps();

      $table->unique(['keyword_id','product_id'], 'uk_keyword_product_v1');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('search_keyword_products_v1');
  }
};