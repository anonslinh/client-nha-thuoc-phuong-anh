<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable()->comment('NULL nếu banner dùng cho toàn hệ thống');
            $table->string('title')->comment('Tên banner');
            $table->string('image_url')->comment('URL hình ảnh banner');
            $table->string('redirect_url')->nullable()->comment('Link chuyển hướng khi click vào banner');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Trạng thái banner');
            $table->dateTime('start_date')->nullable()->comment('Thời gian bắt đầu hiển thị');
            $table->dateTime('end_date')->nullable()->comment('Thời gian kết thúc hiển thị');
            $table->timestamps();

        });

        // Chèn dữ liệu mẫu sau khi tạo bảng
        DB::table('banners')->insert([
            ['title' => 'Banner mẫu', 'image_url' => 'assets/images/config/banner_example.webp', 'status' => 'active',
                'start_date' => Carbon::now(), 'end_date' => Carbon::now()->addMonth()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
