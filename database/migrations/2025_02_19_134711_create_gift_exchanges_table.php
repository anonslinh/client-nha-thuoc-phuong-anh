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
        Schema::create('gift_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // ID khách hàng
            $table->string('contact_phone')->nullable(); // Số điện thoại của khách hàng
            $table->unsignedBigInteger('gift_id'); // ID quà tặng
            $table->unsignedBigInteger('branch_id')->nullable(); // ID chi nhánh
            $table->string('exchange_code'); // Mã đổi quà (unique)
            $table->integer('points_used'); // Số điểm đã sử dụng
            $table->timestamp('exchange_date')->nullable(); // Ngày đổi quà
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Trạng thái đổi quà
            $table->text('notes')->nullable(); // Ghi chú về việc đổi quà
            $table->timestamps();

            // Foreign keys
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_exchanges');
    }
};
