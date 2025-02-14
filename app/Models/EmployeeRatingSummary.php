<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRatingSummary extends Model
{
    use HasFactory;

    protected $table = 'employee_rating_summaries';

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'rating_1',
        'rating_2',
        'rating_3',
        'rating_4',
        'rating_5'
    ];

    /**
     * Cập nhật bảng tổng hợp đánh giá nhân viên theo tháng/năm.
     */
    public static function updateRatingSummary($employeeId, $rating)
    {
        $month = now()->month;
        $year = now()->year;

        // Xác định cột cần cập nhật
        $ratingColumn = "rating_" . $rating;

        // Cập nhật hoặc tạo mới tổng hợp đánh giá
        return self::updateOrInsert(
            ['employee_id' => $employeeId, 'month' => $month, 'year' => $year],
            [$ratingColumn => \DB::raw("$ratingColumn + 1")]
        );
    }
}
