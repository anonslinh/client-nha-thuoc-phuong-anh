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
        Schema::create('customer_ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index()->comment('Liên kết với bảng customers');
            $table->enum('current_rank', ['than_thiet', 'bac', 'vang', 'kim_cuong'])->default('than_thiet');
            $table->dateTime('rank_start_date')->nullable()->comment('Ngày bắt đầu hạng hiện tại');
            $table->dateTime('rank_end_date')->nullable()->comment('Ngày kết thúc hạng hiện tại');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ranks');
    }
};
