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
        Schema::create('quantity_gift_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_events_id');
            $table->unsignedBigInteger('branch_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('gift_events_id')->references('id')->on('gift_event')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantity_gift_events');
    }
};
