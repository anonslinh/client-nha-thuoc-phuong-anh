<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_kiot_sync_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_category_v1')->nullable()->index();
            $table->unsignedBigInteger('kiot_category_id')->nullable()->index();
            $table->string('kiot_category_name')->nullable();

            $table->tinyInteger('status')->default(1)->index();
            $table->timestamp('last_synced_at')->nullable();

            $table->timestamps();

            $table->unique(['id_category_v1', 'kiot_category_id'], 'uk_category_kiot_sync_v1');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_kiot_sync_v1');
    }
};