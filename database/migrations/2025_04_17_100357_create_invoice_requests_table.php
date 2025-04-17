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
        Schema::create('invoice_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // liên kết với bảng hóa đơn
            $table->string('type'); // 'personal' hoặc 'company'
            $table->string('status')->default('pending'); // 'pending', 'processing', 'completed', v.v.
            $table->string('result_url')->nullable(); // link trả kết quả
            $table->string('invoice_code')->nullable(); //Mã hoá đơn kiotviet

            // Trường chung
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->text('note')->nullable();

            // Chỉ cho công ty
            $table->string('tax_code')->nullable();
            $table->string('company_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_requests');
    }
};
