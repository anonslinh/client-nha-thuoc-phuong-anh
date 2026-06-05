<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flash_sale_items_v1', function (Blueprint $table) {
            $table->string('item_name')->nullable()->after('product_id');
            $table->text('item_image')->nullable()->after('item_name');
        });
    }

    public function down(): void
    {
        Schema::table('flash_sale_items_v1', function (Blueprint $table) {
            $table->dropColumn(['item_name', 'item_image']);
        });
    }
};