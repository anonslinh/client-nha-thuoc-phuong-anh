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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kiotviet_id')->unique()->comment('ID hóa đơn từ KiotViet');
            $table->string('contact_number')->index();
            $table->string('personal_access_token');
            $table->string('uuid')->unique();
            $table->string('code')->unique();
            $table->dateTime('purchase_date');
            $table->unsignedBigInteger('branch_id');
            $table->string('branch_name');
            $table->unsignedBigInteger('sold_by_id');
            $table->string('sold_by_name');
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('customer_code')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('order_code')->nullable();
            $table->decimal('total', 15, 4);  // Số lượng chữ số thập phân là 4 để khớp dữ liệu
            $table->decimal('total_payment', 15, 4);
            $table->decimal('discount', 15, 4)->default(0);
            $table->integer('status');
            $table->string('status_value');
            $table->boolean('using_cod');
            $table->text('description')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
