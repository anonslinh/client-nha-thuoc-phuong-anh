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
        Schema::create('send_mail_kpi_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_employee_id'); // ID nhân viên
            $table->timestamp('sent_at'); // Ngày gửi mail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_mail_kpi_logs');
    }
};
