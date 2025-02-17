<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề chương trình
            $table->text('sub_title'); // Mô tả tiêu đề chương trình
            $table->text('description')->nullable(); // Mô tả chương trình
            $table->string('join_link')->nullable();
            $table->boolean('active_join_link')->default(false); // Mặc định không hiển thị
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Trạng thái khuyến mại');
            $table->date('start_date'); // Ngày bắt đầu
            $table->date('end_date'); // Ngày kết thúc
            $table->string('apply_to')->default('all'); // Đối tượng áp dụng
            $table->string('image_path')->default('default_promotion.jpg'); // Ảnh mặc định
            $table->integer('priority')->default(0)->comment('Thứ tự ưu tiên hiển thị, số càng lớn càng ưu tiên');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
