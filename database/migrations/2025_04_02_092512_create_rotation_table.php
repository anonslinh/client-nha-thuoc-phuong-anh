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
        Schema::create('rotation', function (Blueprint $table) {
            $table->id();
            $table->date('time_start');
            $table->date('time_end');
            $table->string('title');
            $table->timestamps();
        });
        Schema::create('rule_rotation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rotation_id')->constrained('rotation')->onDelete('cascade');
            $table->integer('money_invoice_1')->default(0);
            $table->integer('money_invoice_2');
            $table->timestamps();
        });
        Schema::create('gift_rotation', function (Blueprint $table) {
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
        Schema::dropIfExists('rotation');
        Schema::dropIfExists('rule_rotation');
        Schema::dropIfExists('gift_rotation');
    }
};
