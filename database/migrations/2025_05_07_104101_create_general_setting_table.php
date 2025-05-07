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
        Schema::create('general_setting', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->tinyInteger('value');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('general_setting')->insert([
            [
                'code' => 'type_point',
                'value' => 1
            ],
            [
                'code' => 'product_gift',
                'value' => 0
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_setting');
    }
};
