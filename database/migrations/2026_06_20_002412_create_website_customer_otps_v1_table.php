<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_customer_otps_v1', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20);
            $table->string('otp', 10);
            $table->string('tracking_id', 100)->nullable();

            $table->unsignedTinyInteger('attempt_count')->default(0)->comment('Số lần nhập sai OTP');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('expires_at')->comment('Hiệu lực ~5 phút kể từ lúc gửi');

            $table->timestamps();

            $table->index(['phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_customer_otps_v1');
    }
};
