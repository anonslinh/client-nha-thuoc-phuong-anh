<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_setting', function (Blueprint $table) {
            // Nới rộng để chứa được nội dung dài (vd: mô tả popup thử nghiệm)
            $table->text('value')->change();
        });
    }

    public function down(): void
    {
        Schema::table('general_setting', function (Blueprint $table) {
            $table->string('value', 255)->change();
        });
    }
};
