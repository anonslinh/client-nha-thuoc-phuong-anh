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
        Schema::create('slogans', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->timestamps();
        });

        // Chèn dữ liệu mẫu sau khi tạo bảng
        DB::table('slogans')->insert([
            ['title' => 'Chất lượng tốt - Giá cả tốt - Phục vụ tốt'],
            ['title' => 'Cửa hàng WinBaby'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slogans');
    }
};
