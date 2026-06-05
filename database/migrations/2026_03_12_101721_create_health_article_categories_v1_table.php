<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('health_article_categories_v1', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_article_categories_v1');
    }
};