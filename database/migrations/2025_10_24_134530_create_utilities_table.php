<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('utilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_room'); // id phòng (không FK)
            $table->string('name');                // tên tiện ích
            $table->string('icon')->nullable();    // link ảnh icon
            $table->string('short_desc')->nullable(); // mô tả ngắn tiện ích
            $table->unsignedTinyInteger('status')->default(1); // 1 hiện; 0 ẩn
            $table->timestamps();

            $table->index('id_room');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilities');
    }
};
