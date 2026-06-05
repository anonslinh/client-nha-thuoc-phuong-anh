<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // tự tăng
            $table->string('name');                       // tên phòng
            $table->unsignedInteger('price')->default(0);         // giá hiển thị
            $table->unsignedInteger('price_listed')->default(0);  // giá gốc
            $table->string('img_avatar')->nullable();     // ảnh hiển thị ngoài danh sách
            $table->string('img_banner')->nullable();     // ảnh hiển thị banner
            $table->string('link_video')->nullable();     // link của video phòng
            $table->string('note_services')->nullable();  // mô tả ngắn gọn dịch vụ
            $table->unsignedTinyInteger('type')->default(1);      // 1: đơn; 2: đôi; 3: 3 giường
            $table->longText('description')->nullable();  // mô tả thông tin phòng
            $table->unsignedTinyInteger('is_active')->default(1); // 0 ẩn, 1 hiện
            $table->unsignedTinyInteger('status')->default(1);    // 0 hết phòng, 1 còn phòng
            $table->timestamps();

            // Index gợi ý (không phải FK)
            $table->index(['is_active', 'status']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
