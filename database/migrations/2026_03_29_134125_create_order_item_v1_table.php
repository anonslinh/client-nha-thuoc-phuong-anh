<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_v1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order_v1')->comment('ID đơn hàng');
            $table->unsignedBigInteger('id_product_v1')->comment('ID sản phẩm trên website');
            $table->unsignedBigInteger('kiotviet_product_id')->nullable()->comment('ID sản phẩm bên KiotViet');

            $table->string('product_code_snapshot', 100)->nullable()->comment('Mã sản phẩm snapshot');
            $table->string('product_name_snapshot', 255)->comment('Tên sản phẩm snapshot');
            $table->text('product_image_snapshot')->nullable()->comment('Ảnh sản phẩm snapshot');
            $table->decimal('price_snapshot', 15, 2)->default(0)->comment('Đơn giá tại thời điểm chốt đơn');
            $table->unsignedInteger('quantity')->default(1)->comment('Số lượng');
            $table->decimal('line_total', 15, 2)->default(0)->comment('Thành tiền dòng');
            $table->text('note')->nullable()->comment('Ghi chú riêng cho sản phẩm trong đơn nếu có');
            $table->timestamps();

            $table->index(['id_order_v1']);
            $table->index(['id_product_v1']);
            $table->index(['kiotviet_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_v1');
    }
};