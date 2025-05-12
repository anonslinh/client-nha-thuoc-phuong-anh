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
        Schema::table('gift_exchanges', function (Blueprint $table) {
            $table->string('gift_name')->nullable();
            $table->string('gift_code')->nullable();

            // Xóa foreign key (giả sử foreign key tên là orders_user_id_foreign)
            $table->dropForeign(['gift_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
