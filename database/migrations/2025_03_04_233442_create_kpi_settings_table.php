<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpi_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('default_kpi')->default(70);
            $table->integer('min_kpi')->default(30);
            $table->integer('max_kpi')->default(120);
            $table->integer('star_1')->default(-12);
            $table->integer('star_2')->default(-7);
            $table->integer('star_3')->default(-3);
            $table->integer('star_4')->default(1);
            $table->integer('star_5')->default(3);
            $table->integer('orders_required')->default(10);
            $table->integer('min_order_value')->default(0);
            $table->integer('reward_points')->default(1);
            $table->date('cutoff_date')->default(now()); // Thêm cột ngày bắt đầu tính đánh giá
            $table->timestamps();
        });

        // Chèn dữ liệu mặc định
        DB::table('kpi_settings')->insert([
            'default_kpi' => 70,
            'min_kpi' => 30,
            'max_kpi' => 120,
            'star_1' => -12,
            'star_2' => -7,
            'star_3' => -3,
            'star_4' => 1,
            'star_5' => 3,
            'orders_required' => 10,
            'min_order_value' => 0,
            'reward_points' => 1,
            'cutoff_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_settings');
    }
};
