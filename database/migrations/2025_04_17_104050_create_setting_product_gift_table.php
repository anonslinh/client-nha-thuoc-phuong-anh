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
        Schema::create('setting_product_gift', function (Blueprint $table) {
            $table->id();
            $table->boolean('active_api')->default(0);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('setting_product_gift')->insert([
            'active_api' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_product_gift');
    }
};
