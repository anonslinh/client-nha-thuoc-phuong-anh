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
        Schema::create('voucher_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // ID khách hàng
            $table->string('contact_phone')->nullable(); // Số điện thoại của khách hàng
            $table->unsignedBigInteger('voucher_id'); // ID voucher
            $table->unsignedBigInteger('branch_id')->nullable(); // ID chi nhánh (nếu cần)
            $table->string('exchange_code')->unique(); // Mã đổi voucher
            $table->integer('discount_amount'); // Số tiền cho mã voucher
            $table->integer('points_used'); // Số điểm đã sử dụng
            $table->timestamp('exchange_date')->nullable(); // Ngày đổi voucher
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Trạng thái đổi voucher
            $table->text('notes')->nullable(); // Ghi chú
            $table->string('account_code')->nullable(); // Mã code của cửa hàng
            $table->string('release_code')->nullable(); // Mã phát hành kiotviet
            $table->string('voucher_campaign_id')->nullable(); // ID mã phát hành kiotviet
            $table->timestamps();

            // Foreign keys
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_exchanges');
    }
};
