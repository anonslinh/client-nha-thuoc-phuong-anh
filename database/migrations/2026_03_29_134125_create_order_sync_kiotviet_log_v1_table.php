<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_sync_kiotviet_log_v1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order_v1')->comment('ID đơn hàng web');
            $table->unsignedTinyInteger('sync_type')->default(2)->comment('1: sync order, 2: sync invoice');
            $table->longText('request_payload')->nullable()->comment('Payload gửi sang KiotViet');
            $table->longText('response_payload')->nullable()->comment('Dữ liệu phản hồi từ KiotViet');
            $table->unsignedTinyInteger('status')->default(0)->comment('0: thất bại, 1: thành công');
            $table->text('error_message')->nullable()->comment('Thông báo lỗi sync');
            $table->unsignedBigInteger('created_by')->nullable()->comment('ID user thao tác sync');
            $table->timestamp('created_at')->useCurrent()->comment('Thời điểm thực hiện sync');

            $table->index(['id_order_v1']);
            $table->index(['sync_type']);
            $table->index(['status']);
            $table->index(['created_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_sync_kiotviet_log_v1');
    }
};