<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('category_v1', function (Blueprint $table) {
      $table->id();

      $table->string('name')->nullable();
      $table->text('description')->nullable();
      $table->text('img')->nullable();

      $table->integer('sort_order'); // không được null
      $table->tinyInteger('status')->default(1);

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('category_v1');
  }
};