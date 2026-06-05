<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners_v1', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('type_hide')->default(1)->index(); // 1 = hiện, 0 = ẩn
            $table->integer('sort_order')->default(0)->index();

            $table->string('title')->nullable();
            $table->longText('content')->nullable();

            $table->text('link_web')->nullable();
            $table->text('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners_v1');
    }
};