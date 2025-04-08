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
        Schema::create('gift_rotation_quantity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_rotation_id')->constrained('gift_rotation')->onDelete('cascade');
            $table->foreignId('branches_id')->constrained('branches')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_rotation_quantity');
    }
};
