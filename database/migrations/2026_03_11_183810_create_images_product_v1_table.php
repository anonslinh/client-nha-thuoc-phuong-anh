<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('images_product_v1', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('id_product_v1')->nullable()->index();
      $table->text('link_img')->nullable();
      $table->tinyInteger('status')->nullable()->default(1);

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('images_product_v1');
  }
};