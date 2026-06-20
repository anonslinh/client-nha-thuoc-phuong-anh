<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_fee_rules_v1', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 15, 2)->default(0)->comment('Giá trị đơn hàng tối thiểu áp dụng (đồng)');
            $table->decimal('max_amount', 15, 2)->nullable()->comment('Giá trị đơn hàng tối đa áp dụng (null = không giới hạn)');
            $table->decimal('fee', 15, 2)->default(0)->comment('Phí ship áp dụng (0 = miễn phí ship)');
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->index(['is_active']);
            $table->index(['min_amount']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_fee_rules_v1');
    }
};
