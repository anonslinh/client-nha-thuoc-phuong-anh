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
        Schema::create('employee_kpis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_employee_id'); // ID nhân viên
            $table->integer('month'); // Tháng
            $table->integer('year'); // Năm
            $table->integer('points')->default(100)->comment('Điểm KPI'); // Điểm KPI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_kpis');
    }
};
