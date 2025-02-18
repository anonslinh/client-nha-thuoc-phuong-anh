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
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'than_thiet', 'bac', 'vang', 'kim_cuong'
            $table->string('rank')->unique(); // 'than_thiet', 'bac', 'vang', 'kim_cuong'
            $table->decimal('spending_threshold', 15, 2)->default(0); // Số tiền tối thiểu để đạt hạng này
            $table->timestamps();
        });

        // Chèn dữ liệu mẫu sau khi tạo bảng
        DB::table('membership_levels')->insert([
            ['name' => 'Thân thiết', 'rank' => 'than_thiet', 'spending_threshold' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Hạng Bạc', 'rank' => 'bac', 'spending_threshold' => 1000000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Hạng Vàng', 'rank' => 'vang', 'spending_threshold' => 3000000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Hạng Kim Cương', 'rank' => 'kim_cuong', 'spending_threshold' => 5000000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_levels');
    }
};
