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
        Schema::create('customer_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('personal_access_token');
            $table->bigInteger('kiotviet_id')->index();
            $table->decimal('total_invoiced', 15, 2)->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->integer('total_point')->default(0);
            $table->integer('reward_point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_sync_logs');
    }
};
