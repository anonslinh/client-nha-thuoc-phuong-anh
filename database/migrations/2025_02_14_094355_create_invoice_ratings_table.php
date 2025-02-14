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
        Schema::create('invoice_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_invoice_id'); // ID hóa đơn
            $table->unsignedBigInteger('kiotviet_customer_id'); // ID khách hàng đánh giá
            $table->unsignedBigInteger('employee_id')->index(); // ID nhân viên xử lý hóa đơn
            $table->tinyInteger('rating')->index()->comment('Số sao (1-5)'); // Điểm đánh giá
            $table->text('comment')->nullable()->comment('Nhận xét của khách hàng'); // Nhận xét của khách hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_ratings');
    }
};
