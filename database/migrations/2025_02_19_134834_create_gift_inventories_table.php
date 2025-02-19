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
        Schema::create('gift_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_id'); // ID quà tặng
            $table->unsignedBigInteger('branch_id'); // ID chi nhánh
            $table->integer('quantity')->default(0); // Số lượng quà còn lại
            $table->timestamps();

            // Foreign keys
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_inventories');
    }
};
