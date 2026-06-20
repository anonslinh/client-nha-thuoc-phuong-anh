<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_codes_v1', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->default(1)->comment('1: voucher (chọn từ danh sách), 2: mã giảm giá (nhập tay)');
            $table->string('code', 50)->unique()->comment('Mã định danh, dùng để áp dụng');
            $table->string('title', 255)->comment('Tên hiển thị cho khách');
            $table->text('description')->nullable();

            $table->unsignedTinyInteger('discount_type')->default(1)->comment('1: theo %, 2: số tiền cố định');
            $table->decimal('discount_value', 15, 2)->default(0)->comment('Giá trị giảm (% hoặc đồng tùy discount_type)');
            $table->decimal('max_discount_amount', 15, 2)->nullable()->comment('Số tiền giảm tối đa (áp dụng khi discount_type = %)');
            $table->decimal('min_order_amount', 15, 2)->default(0)->comment('Giá trị đơn hàng tối thiểu để áp dụng');

            $table->unsignedInteger('quantity')->nullable()->comment('Số lượt sử dụng tối đa, null = không giới hạn');
            $table->unsignedInteger('used_count')->default(0);

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);

            $table->timestamps();

            $table->index(['type']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_codes_v1');
    }
};
