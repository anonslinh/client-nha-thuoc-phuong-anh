<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('room_day_statuses', function (Blueprint $table) {
            // số lượng phòng bán trong ngày (default sẽ set theo rooms.number_rooms khi seed)
            $table->unsignedInteger('total_qty')->default(0)->after('price');

            // giữ chỗ tạm (nếu bạn cần) - hiện để 0
            $table->unsignedInteger('hold_qty')->default(0)->after('total_qty');

            // số lượng đã đặt (confirmed)
            $table->unsignedInteger('booked_qty')->default(0)->after('hold_qty');
        });
    }

    public function down(): void
    {
        Schema::table('room_day_statuses', function (Blueprint $table) {
            $table->dropColumn(['total_qty', 'hold_qty', 'booked_qty']);
        });
    }
};
