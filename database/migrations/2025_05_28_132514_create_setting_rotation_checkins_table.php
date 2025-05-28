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
        Schema::create('setting_rotation_checkins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('time_start');
            $table->date('time_end');
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->string('rotation')->nullable();
            $table->string('color_button')->nullable();
            $table->string('color_gift')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_rotation_checkins');
    }
};
