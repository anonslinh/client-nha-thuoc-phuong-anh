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
        Schema::create('rotation_checkin', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('image');
            $table->integer('branch_id');
            $table->boolean('use')->default(0);
            $table->timestamps();
        });
        Schema::create('gift_checkin', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->string('image');
            $table->float('percent')->default(0);
            $table->timestamps();
        });
        Schema::create('quantity_gift_checkin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_checkin_id')->constrained('gift_checkin')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
        Schema::create('customer_gift_checkin', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('gift_name');
            $table->string('gift_code');
            $table->string('gift_image');
            $table->string('branch_name');
            $table->string('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotation_checkin');
        Schema::dropIfExists('gift_checkin');
        Schema::dropIfExists('quantity_gift_checkin');
        Schema::dropIfExists('customer_gift_checkin');
    }
};
