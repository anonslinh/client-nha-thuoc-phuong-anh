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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'Tên'
            $table->string('type'); // 'zalo', 'phone', 'email'
            $table->string('value'); // Số điện thoại, email hoặc link Zalo
            $table->timestamps();
        });

        // Chèn dữ liệu mẫu sau khi tạo bảng
        DB::table('contacts')->insert([
            ['name' => 'Zalo OA', 'type' => 'zalo', 'value' => '4579606723122854828'],
            ['name' => 'Số điện thoại', 'type' => 'phone', 'value' => '0387287333'],
            ['name' => 'Email', 'type' => 'email', 'value' => 'winsinternational.co.ltd@gmail.com'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
