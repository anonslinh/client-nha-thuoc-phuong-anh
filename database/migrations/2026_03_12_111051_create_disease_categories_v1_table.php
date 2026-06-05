<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disease_categories_v1', function (Blueprint $table) {
            $table->id();

            $table->text('avatar')->nullable();
            $table->text('banner')->nullable();

            $table->string('name')->nullable();
            $table->text('short_description')->nullable();

            $table->tinyInteger('type')->default(1)->index(); // 1=bệnh theo mùa, 2=bệnh theo đối tượng
            $table->integer('sort_order')->default(0)->index();
            $table->tinyInteger('status')->default(1)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disease_categories_v1');
    }
};