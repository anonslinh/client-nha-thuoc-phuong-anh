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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên deal (VD: Deal 9K, Sale 50%)
            $table->text('description')->nullable(); // Mô tả
            $table->decimal('discount', 5, 2)->nullable(); // Giảm giá % (nếu có)
            $table->decimal('fixed_price', 10, 2)->nullable(); // Giá cố định (nếu có)
            $table->dateTime('start_time'); // Thời gian bắt đầu
            $table->dateTime('end_time'); // Thời gian kết thúc
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái deal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
