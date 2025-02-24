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
        Schema::create('daily_activity_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_kiotviet_id')->nullable()->index(); // ID khách hàng (nullable vì có thể có thống kê chung)
            $table->date('date')->index(); // Ngày thống kê
            $table->string('action')->index(); // Loại hành động (view_points, redeem_gift, redeem_voucher, rate, feedback, ...)
            $table->unsignedInteger('count')->default(0); // Tổng số lần thực hiện hành động
            $table->timestamps();

            // Đảm bảo mỗi khách hàng chỉ có 1 bản ghi mỗi ngày cho mỗi action
            $table->unique(['customer_kiotviet_id', 'date', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_summaries');
    }
};
