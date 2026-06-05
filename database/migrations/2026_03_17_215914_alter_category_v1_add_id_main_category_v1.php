<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('category_v1', function (Blueprint $table) {
            $table->unsignedBigInteger('id_main_category_v1')
                ->nullable()
                ->after('id')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('category_v1', function (Blueprint $table) {
            $table->dropColumn('id_main_category_v1');
        });
    }
};