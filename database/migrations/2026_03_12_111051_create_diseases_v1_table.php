<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('diseases_v1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_category')->nullable()->index();

            $table->string('title')->nullable();
            $table->text('short_description')->nullable();

            $table->text('avatar')->nullable();
            $table->text('banner')->nullable();

            $table->longText('content')->nullable();

            $table->tinyInteger('status')->default(1)->index();
            $table->dateTime('posted_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diseases_v1');
    }
};