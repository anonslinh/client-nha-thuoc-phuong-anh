<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_item_v1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cart_v1')->comment('ID giỏ hàng');
            $table->unsignedBigInteger('id_product_v1')->comment('ID sản phẩm trên website');
            $table->unsignedBigInteger('kiotviet_product_id')->nullable()->comment('ID sản phẩm bên KiotViet để phục vụ sync sau này');

            $table->string('product_code_snapshot', 100)->nullable()->comment('Mã sản phẩm snapshot tại thời điểm thêm giỏ');
            $table->string('product_name_snapshot', 255)->comment('Tên sản phẩm snapshot');
            $table->text('product_image_snapshot')->nullable()->comment('Ảnh sản phẩm snapshot');
            $table->decimal('price_snapshot', 15, 2)->default(0)->comment('Giá sản phẩm tại thời điểm thêm giỏ');
            $table->unsignedInteger('quantity')->default(1)->comment('Số lượng');
            $table->decimal('line_total', 15, 2)->default(0)->comment('Thành tiền của dòng giỏ hàng');
            $table->timestamps();

            $table->index(['id_cart_v1']);
            $table->index(['id_product_v1']);
            $table->index(['kiotviet_product_id']);
            $table->index(['id_cart_v1', 'id_product_v1']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item_v1');
    }
};