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
        Schema::create('setting_globals', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->longText('comment');
            $table->timestamps();
        });

        // Chèn dữ liệu mẫu sau khi tạo bảng
        DB::table('setting_globals')->insert([
            ['code' => 'oa_id','title' => 'Zalo OA ID', 'comment' => '4579606723122854828	'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_globals');
    }
};
