<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'room_id')) {
                $table->unsignedBigInteger('room_id')->nullable()->after('email');
                $table->index('room_id');
            }
            if (!Schema::hasColumn('bookings', 'qty')) {
                $table->unsignedSmallInteger('qty')->default(1)->after('check_out_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'qty')) $table->dropColumn('qty');
            if (Schema::hasColumn('bookings', 'room_id')) {
                $table->dropIndex(['room_id']);
                $table->dropColumn('room_id');
            }
        });
    }
};
