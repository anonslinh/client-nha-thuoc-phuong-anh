<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorite_trademarks_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('trademark_id')->index();  // trademark_v1.id

            $table->text('featured_image')->nullable();           // upload path hoặc url
            $table->string('short_desc', 255)->nullable();        // vd: "Giảm đến 20%"

            $table->integer('sort_order')->default(0)->index();
            $table->tinyInteger('status')->default(1);

            $table->timestamps();

            $table->unique(['trademark_id'], 'favorite_trademarks_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_trademarks_v1');
    }
};