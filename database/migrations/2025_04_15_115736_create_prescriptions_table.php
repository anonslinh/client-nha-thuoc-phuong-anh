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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('age')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->text('image')->nullable(); // đường dẫn ảnh
            $table->text('note')->nullable();
            $table->string('status')->default('pending'); // pending, processing, done, canceled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
