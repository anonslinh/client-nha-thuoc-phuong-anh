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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên quà tặng
            $table->string('image')->nullable(); // Hình ảnh quà
            $table->longText('description')->nullable(); // Hình ảnh quà
            $table->unsignedBigInteger('branch_id')->nullable(); // Chi nhánh áp dụng, null = toàn hệ thống
            $table->boolean('is_display')->default(false); // Quà trưng bày (hiển thị khi chưa có branch_id)
            $table->integer('points_required'); // Điểm yêu cầu để đổi quà
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
