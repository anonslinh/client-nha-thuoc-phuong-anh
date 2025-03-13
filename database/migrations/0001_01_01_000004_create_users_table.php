<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Liên kết với bảng employees qua kiotviet_id
            $table->unsignedBigInteger('employee_kiotviet_id')->nullable();
            $table->foreign('employee_kiotviet_id')->references('kiotviet_id')->on('employees')->onDelete('cascade');

            $table->enum('role', ['admin', 'manager', 'staff'])->default('staff');
            $table->json('permissions')->nullable(); // Lưu quyền truy cập menu dưới dạng JSON
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Chèn tài khoản admin mặc định
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin.winbaby@gmail.com',
            'password' => Hash::make('Winbaby123'),
            'role' => 'admin', // Đặt vai trò là admin
            'permissions' => json_encode(['all']), // Cấp quyền truy cập toàn bộ hệ thống
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_kiotviet_id', 'kiotviet_id');
    }
};
