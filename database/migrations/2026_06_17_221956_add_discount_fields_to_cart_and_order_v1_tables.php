<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_item_v1', function (Blueprint $table) {
            $table->decimal('original_price_snapshot', 15, 2)->nullable()->after('price_snapshot')
                ->comment('Giá gốc trước khi giảm (flash sale/khuyến mãi) tại thời điểm snapshot');
        });

        Schema::table('order_v1', function (Blueprint $table) {
            $table->string('voucher_code', 50)->nullable()->after('discount_amount')->comment('Mã voucher/giảm giá đã áp dụng');
            $table->unsignedBigInteger('id_discount_code_v1')->nullable()->after('voucher_code')->comment('FK discount_codes_v1');
            $table->decimal('auto_discount_amount', 15, 2)->default(0)->after('id_discount_code_v1')->comment('Tổng tiền tiết kiệm tự động từ flash sale/khuyến mãi (chỉ để hiển thị, đã nằm trong subtotal)');
        });
    }

    public function down(): void
    {
        Schema::table('cart_item_v1', function (Blueprint $table) {
            $table->dropColumn('original_price_snapshot');
        });

        Schema::table('order_v1', function (Blueprint $table) {
            $table->dropColumn(['voucher_code', 'id_discount_code_v1', 'auto_discount_amount']);
        });
    }
};
