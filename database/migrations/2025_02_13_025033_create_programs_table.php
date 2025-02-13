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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề
            $table->text('description'); // Nội dung chi tiết
            $table->unsignedBigInteger('branch_id')->nullable(); // Chi nhánh tổ chức (nullable để hiển thị toàn bộ)
            $table->string('thumbnail'); // Ảnh đại diện (thumbnail)
            $table->json('images'); // Danh sách ảnh cho slider
            $table->string('join_link')->nullable();
            $table->boolean('active_join_link')->default(false); // Mặc định không hiển thị
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Trạng thái chương trình');
            $table->dateTime('start_date')->nullable()->comment('Thời gian bắt đầu hiển thị');
            $table->dateTime('end_date')->nullable()->comment('Thời gian kết thúc hiển thị');
            $table->integer('priority')->default(0)->comment('Thứ tự ưu tiên hiển thị, số càng lớn càng ưu tiên');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
