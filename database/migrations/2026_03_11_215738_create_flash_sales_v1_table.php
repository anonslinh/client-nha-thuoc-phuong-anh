<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flash_sales_v1', function (Blueprint $table) {
            $table->id();

            $table->date('sale_date')->index();          // ngày diễn ra
            $table->time('start_time')->index();         // giờ bắt đầu
            $table->time('end_time')->index();           // giờ kết thúc

            $table->string('title')->nullable();         // optional
            $table->tinyInteger('status')->default(1);   // 1=active,0=off

            $table->timestamps();

            $table->index(['sale_date','start_time','end_time'], 'flash_sale_date_time_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sales_v1');
    }
};