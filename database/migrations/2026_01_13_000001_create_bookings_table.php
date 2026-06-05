<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();

            $table->string('customer_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();

            $table->date('check_in_date');
            $table->date('check_out_date');

            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);

            $table->string('status', 20)->default('pending'); // pending|confirmed|checked_in|checked_out|cancelled|no_show
            $table->string('payment_status', 20)->default('unpaid'); // unpaid|partial|paid|refunded

            $table->decimal('deposit_amount', 14, 2)->nullable();
            $table->decimal('total_amount', 14, 2)->nullable();
            $table->decimal('paid_amount', 14, 2)->nullable();

            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['check_in_date', 'check_out_date']);
            $table->index(['status', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
