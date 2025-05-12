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
        Schema::table('gift_event', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->comment('1: qua tang; 2: voucher');
            $table->text('release_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gift_event', function (Blueprint $table) {
            //
        });
    }
};
