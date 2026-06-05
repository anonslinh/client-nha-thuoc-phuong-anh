<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('text_seo_header', function (Blueprint $table) {
            $table->id();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->longText('article_content')->nullable();

            $table->integer('sort_order')->default(0)->index();

            $table->text('banner')->nullable();
            $table->text('see_more_link')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('text_seo_header');
    }
};