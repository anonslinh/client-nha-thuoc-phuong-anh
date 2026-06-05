<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_log_v1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order_v1')->comment('ID đơn hàng');
            $table->unsignedTinyInteger('from_status')->nullable()->comment('Trạng thái cũ');
            $table->unsignedTinyInteger('to_status')->comment('Trạng thái mới');
            $table->text('note')->nullable()->comment('Ghi chú khi chuyển trạng thái');
            $table->unsignedBigInteger('changed_by')->nullable()->comment('ID user thao tác');
            $table->timestamp('created_at')->useCurrent()->comment('Thời điểm đổi trạng thái');

            $table->index(['id_order_v1']);
            $table->index(['to_status']);
            $table->index(['changed_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_log_v1');
    }
};