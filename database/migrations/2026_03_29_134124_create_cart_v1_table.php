<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_v1', function (Blueprint $table) {
            $table->id();
            $table->string('cart_token', 100)->unique()->comment('Token nhận diện giỏ hàng lưu trên cookie');
            $table->unsignedTinyInteger('status')->default(0)->comment('0: đang hoạt động, 1: đã chuyển thành đơn, 2: hết hiệu lực/hủy');
            $table->unsignedInteger('total_quantity')->default(0)->comment('Tổng số lượng sản phẩm trong giỏ');
            $table->decimal('subtotal_amount', 15, 2)->default(0)->comment('Tổng tiền tạm tính của giỏ');
            $table->timestamps();

            $table->index(['status']);
            $table->index(['updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_v1');
    }
};