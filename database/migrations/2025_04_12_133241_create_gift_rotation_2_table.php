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
        Schema::create('gift_rotation_2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_rotation_id')->constrained('rule_rotation')->onDelete('cascade');
            $table->string('title');
            $table->string('code');
            $table->string('image');
            $table->integer('quantity');
            $table->float('percent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_rotation_2');
    }
};
