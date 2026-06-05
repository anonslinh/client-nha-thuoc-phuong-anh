<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('text_seo_header', function (Blueprint $table) {
            $table->tinyInteger('has_product_list')->default(0)->after('article_content')->index();
        });
    }

    public function down(): void
    {
        Schema::table('text_seo_header', function (Blueprint $table) {
            $table->dropColumn('has_product_list');
        });
    }
};