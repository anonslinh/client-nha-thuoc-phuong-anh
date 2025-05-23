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
        Schema::create('customer_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('contact_number');
            $table->unsignedBigInteger('invoice_id')->nullable(); // nếu có liên kết đơn hàng
            $table->date('schedule_date')->nullable(); // ngày cần gọi
            $table->text('note')->nullable(); // ghi chú cần gọi
            $table->enum('status', ['pending', 'done', 'overdue'])->default('pending');
            $table->timestamp('called_at')->nullable(); // thời gian thực gọi
            $table->text('result_note')->nullable(); // ghi chú kết quả
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_follow_ups');
    }
};
