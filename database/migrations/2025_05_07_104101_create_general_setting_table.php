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
            $table->string('value');
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
            ],
            [
                'code' => 'time_point',
                'value' => \Carbon\Carbon::now()->subYear()->addDay()->toDateString()
            ],
            [
                'code' => 'invoice',
                'value' => 1
            ],
            [
                'code' => 'calculator_point',
                'value' => 0
            ],
            [
                'code' => 'gift_code',
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
