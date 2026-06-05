<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_requests_v1', function (Blueprint $table) {
            $table->id();

            $table->string('request_code', 50)->unique()->comment('Mã yêu cầu mua thuốc');
            $table->string('customer_name', 255)->comment('Họ tên khách hàng');
            $table->string('customer_phone', 20)->comment('Số điện thoại khách hàng');
            $table->text('customer_address')->nullable()->comment('Địa chỉ khách hàng');

            $table->text('prescription_image')->nullable()->comment('Ảnh đơn thuốc');
            $table->longText('prescription_content')->nullable()->comment('Nội dung đơn thuốc / nhu cầu mua thuốc');
            $table->text('note')->nullable()->comment('Ghi chú của khách hàng');

            $table->unsignedTinyInteger('status')->default(0)->comment('0: chưa xác nhận, 1: đã xác nhận, 2: đã xử lý');

            $table->unsignedBigInteger('branch_id')->nullable()->comment('Chi nhánh xử lý');
            $table->unsignedBigInteger('assigned_user_id')->nullable()->comment('Nhân viên/dược sĩ phụ trách');
            $table->unsignedBigInteger('created_order_id')->nullable()->comment('Đơn hàng được tạo từ yêu cầu này nếu có');

            $table->text('admin_note')->nullable()->comment('Ghi chú nội bộ của admin');
            $table->longText('pharmacist_response')->nullable()->comment('Phản hồi/tư vấn từ dược sĩ');

            $table->timestamp('confirmed_at')->nullable()->comment('Thời gian xác nhận');
            $table->timestamp('processed_at')->nullable()->comment('Thời gian xử lý xong');

            $table->timestamps();

            $table->index(['customer_phone']);
            $table->index(['status']);
            $table->index(['branch_id']);
            $table->index(['assigned_user_id']);
            $table->index(['created_order_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_requests_v1');
    }
};