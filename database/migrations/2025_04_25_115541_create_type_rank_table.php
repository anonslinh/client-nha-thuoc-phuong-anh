<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_rank', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1: Tinh theo muc chi tieu; 2: Tinh theo diem')->default(1);
            $table->tinyInteger('time')->default(12)->comment('Số tháng reset lại rank');
            $table->timestamps();
        });
        DB::table('type_rank')->insert([
            'type' => 1,
            'time' => 12,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_rank');
    }
};
