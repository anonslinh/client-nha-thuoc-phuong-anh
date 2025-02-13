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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_id')->unique();
            $table->string('branch_name');
            $table->string('address');
            $table->string('location_name');
            $table->string('ward_name');
            $table->string('contact_number');
            $table->unsignedBigInteger('retailer_id');
            $table->text('email')->nullable();
            $table->timestamp('modified_date')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
