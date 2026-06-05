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
        Schema::table('rooms', function (Blueprint $table) {
            // Thêm cột mới (không unique, chỉ index)
            $table->string('code_url')->nullable()->after('name');
            $table->index('code_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Gỡ index + cột
        Schema::table('rooms', function (Blueprint $table) {
            // Tên index Laravel tự đặt theo convention, an toàn nhất là dropColumn trước
            $table->dropColumn('code_url');
        });
    }
};
