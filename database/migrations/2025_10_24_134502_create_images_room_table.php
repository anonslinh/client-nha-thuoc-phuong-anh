<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('images_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_room');   // id phòng (không FK)
            $table->string('link_image');            // link ảnh
            $table->integer('sort_order')->default(0);      // vị trí ảnh
            $table->unsignedTinyInteger('is_featured')->default(0); // 0/1 ảnh nổi bật
            $table->unsignedTinyInteger('status')->default(1);      // 1 hiện; 0 ẩn
            $table->timestamps();

            $table->index('id_room');
            $table->index(['status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images_room');
    }
};
