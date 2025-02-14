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
        Schema::create('employee_rating_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index(); // ID nhân viên
            $table->integer('month'); // Tháng
            $table->integer('year'); // Năm
            $table->integer('rating_1')->default(0); // Số hóa đơn 1 sao
            $table->integer('rating_2')->default(0); // Số hóa đơn 2 sao
            $table->integer('rating_3')->default(0); // Số hóa đơn 3 sao
            $table->integer('rating_4')->default(0); // Số hóa đơn 4 sao
            $table->integer('rating_5')->default(0); // Số hóa đơn 5 sao
            $table->timestamps();

            $table->unique(['employee_id', 'month', 'year']); // Đảm bảo không có bản ghi trùng lặp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_rating_summaries');
    }
};
