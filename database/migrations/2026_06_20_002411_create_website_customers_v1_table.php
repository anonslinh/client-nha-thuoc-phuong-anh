<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_customers_v1', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->unique()->comment('Số điện thoại đăng nhập (định danh duy nhất)');
            $table->string('name', 255)->nullable()->comment('Họ và tên');
            $table->string('email', 255)->nullable();

            $table->string('province_name', 255)->nullable();
            $table->string('district_name', 255)->nullable();
            $table->string('ward_name', 255)->nullable();
            $table->text('address_detail')->nullable();

            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->index(['phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_customers_v1');
    }
};
