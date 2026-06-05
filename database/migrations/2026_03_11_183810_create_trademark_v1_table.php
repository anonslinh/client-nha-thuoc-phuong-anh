<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('trademark_v1', function (Blueprint $table) {
      $table->id();

      $table->string('name')->nullable();
      $table->text('description')->nullable();
      $table->longText('note')->nullable(); // CKEditor

      $table->text('img')->nullable();
      $table->text('banner')->nullable();

      $table->integer('sort_order'); // không null
      $table->tinyInteger('status')->default(1);

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('trademark_v1');
  }
};