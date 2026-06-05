<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('search_keywords_v1', function (Blueprint $table) {
      $table->id();

      $table->string('key_search', 255)->index();     // từ khóa chính
      $table->longText('related_keywords')->nullable(); // lưu JSON string mảng keywords liên quan

      $table->tinyInteger('type')->default(1)->index(); // 1=hiện,0=ẩn
      $table->integer('sort_order')->default(0)->index();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('search_keywords_v1');
  }
};