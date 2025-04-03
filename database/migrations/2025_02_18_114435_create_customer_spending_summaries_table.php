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
        Schema::create('customer_spending_summaries', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->references('kiotviet_id')->on('customers')->onDelete('cascade');
            $table->string('contact_number')->index();
            $table->integer('month'); // Tháng
            $table->integer('year');  // Năm
            $table->decimal('total_spent', 15, 2)->default(0)->comment('Tổng chi tiêu trong tháng');
            $table->timestamps();

            $table->unique(['customer_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_spending_summaries');
    }
};
