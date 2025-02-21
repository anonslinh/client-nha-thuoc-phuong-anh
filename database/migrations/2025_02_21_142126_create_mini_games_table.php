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
        Schema::create('mini_games', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề game
            $table->dateTime('start_time'); // Thời gian bắt đầu
            $table->dateTime('end_time'); // Thời gian kết thúc
            $table->string('link'); // Link tham gia game
            $table->unsignedBigInteger('branch_id')->nullable(); // Áp dụng cho cửa hàng (NULL = toàn hệ thống)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái hiển thị
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mini_games');
    }
};
