<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_point_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_id'); // ID từ KiotViet
            $table->integer('used_points')->default(0); // Số điểm đã sử dụng
            $table->text('note')->nullable(); // Ghi chú
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_point_logs');
    }
};
