<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_v1', function (Blueprint $table) {
            $table->unsignedBigInteger('id_website_customer_v1')->nullable()->after('cart_token')
                ->comment('Khách hàng đã đăng nhập sở hữu giỏ hàng này (nếu có)');
            $table->index(['id_website_customer_v1']);
        });

        Schema::table('order_v1', function (Blueprint $table) {
            $table->unsignedBigInteger('id_website_customer_v1')->nullable()->after('id_cart_v1')
                ->comment('Khách hàng đã đăng nhập đặt đơn này (nếu có)');
            $table->index(['id_website_customer_v1']);
        });
    }

    public function down(): void
    {
        Schema::table('cart_v1', function (Blueprint $table) {
            $table->dropColumn('id_website_customer_v1');
        });

        Schema::table('order_v1', function (Blueprint $table) {
            $table->dropColumn('id_website_customer_v1');
        });
    }
};
