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
        Schema::create('history_invoice_rotation', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->index();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('rule_rotation_id')->constrained('rule_rotation')->onDelete('cascade');
            $table->string('branch_id')->nullable();
            $table->float('money_invoice')->default(0);
            $table->boolean('used')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('history_gift_rotation', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->index();
            $table->string('name_customer');
            $table->string('phone_customer');
            $table->foreignId('history_invoice_rotation_id')->constrained('history_invoice_rotation')->onDelete('cascade');
            $table->string('name_gift');
            $table->string('image_gift');
            $table->string('code_gift');
            $table->tinyInteger('status')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_invoice_rotation');
        Schema::dropIfExists('history_gift_rotation');
    }
};
