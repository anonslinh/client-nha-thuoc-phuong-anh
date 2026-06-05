<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // tổng số phòng vật lý thuộc loại phòng này
            $table->unsignedSmallInteger('number_rooms')
                  ->default(1)
                  ->after('status'); // đặt sau status, bạn có thể đổi vị trí tùy thích
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('number_rooms');
        });
    }
};
