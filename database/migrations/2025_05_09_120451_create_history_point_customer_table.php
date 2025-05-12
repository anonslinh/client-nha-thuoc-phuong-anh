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
        Schema::create('history_point_customer', function (Blueprint $table) {
            $table->id();
            $table->string('phone_customer')->index();
            $table->string('name_customer')->nullable();
            $table->string('order_code')->index()->nullable();
            $table->string('order_id')->nullable();
            $table->string('title')->index();
            $table->tinyInteger('point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_point_customer');
    }
};
