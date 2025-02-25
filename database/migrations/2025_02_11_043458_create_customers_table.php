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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kiotviet_id')->unique();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('retailer_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('location_name')->nullable();
            $table->string('ward_name')->nullable();
            $table->timestamp('modified_date')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->integer('type')->default(0);
            $table->string('organization')->nullable();
            $table->text('comments')->nullable();
            $table->decimal('debt', 15, 4)->default(0);
            $table->decimal('total_invoiced', 15, 4)->default(0);
            $table->decimal('total_revenue', 15, 4)->default(0);
            $table->integer('total_point')->default(0);
            $table->integer('reward_point')->default(0);
            $table->integer('kiotviet_reward_point')->default(0);
            $table->integer('used_points')->default(0);
            $table->integer('review_count')->default(0);
            $table->integer('total_point_event')->default(0);
            $table->integer('used_point_event')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
