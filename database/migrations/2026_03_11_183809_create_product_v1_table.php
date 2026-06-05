<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('product_v1', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('id_category')->nullable()->index();
      $table->unsignedBigInteger('id_trade_mark')->nullable()->index();

      $table->unsignedBigInteger('id_product_kiotviet')->nullable()->index();
      $table->string('code_product_kiovet', 100)->nullable()->index();

      $table->string('name')->nullable();
      $table->string('full_name')->nullable();

      $table->text('img_avatar')->nullable();        // url hoặc path local
      $table->longText('description')->nullable();   // mô tả ngắn

      $table->decimal('price', 15, 2)->nullable();
      $table->decimal('price_sale', 15, 2)->nullable();

      $table->boolean('is_active')->nullable();      // lấy từ Kiot: isActive
      $table->tinyInteger('status')->nullable()->default(1); // 0/1

      $table->timestamps();

      // chống trùng khi import kiot: unique vẫn cho nhiều NULL
      $table->unique(['id_product_kiotviet'], 'product_v1_unique_kiot_id');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('product_v1');
  }
};