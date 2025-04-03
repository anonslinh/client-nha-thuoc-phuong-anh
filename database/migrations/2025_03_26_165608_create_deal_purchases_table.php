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
        Schema::create('deal_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('deal_product_id'); // Deal tương ứng
            $table->integer('customer_id'); // Khách hàng đặt deal
            $table->string('contact_number');
            $table->integer('store_id'); // Cửa hàng khách chọn nhận deal
            $table->enum('status', ['pending', 'redeemed', 'canceled'])->default('pending'); // Trạng thái đơn
            $table->integer('employee_id')->nullable(); // Nhân viên hỗ trợ khách (nếu có)
            $table->string('employee_name')->nullable();
            $table->dateTime('redeemed_at')->nullable(); // Thời gian khách nhận deal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_purchases');
    }
};
