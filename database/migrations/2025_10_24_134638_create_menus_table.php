<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_room'); // id phòng (không FK)
            $table->string('name');                // tên dịch vụ/món trong thực đơn
            $table->string('image')->nullable();   // link ảnh/icon
            $table->string('short_desc')->nullable(); // mô tả ngắn
            $table->unsignedTinyInteger('status')->default(1);     // 1 hiện; 0 ẩn
            $table->timestamps();

            $table->index('id_room');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
