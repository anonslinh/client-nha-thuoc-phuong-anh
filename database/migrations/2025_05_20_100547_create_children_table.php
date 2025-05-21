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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // khách hàng nào
            $table->string('contact_number');
            $table->string('name')->nullable(); // tên con (nếu có)
            $table->enum('status', ['pregnant', 'born']); // mang bầu hoặc đã sinh
            $table->date('dob')->nullable(); // ngày sinh thực tế hoặc ước lượng
            $table->date('due_date')->nullable(); // ngày dự sinh (nếu đang mang bầu)
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
