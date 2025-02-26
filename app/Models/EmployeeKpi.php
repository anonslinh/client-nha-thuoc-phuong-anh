<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeKpi extends Model
{
    use HasFactory;

    protected $table = 'employee_kpis';

    protected $fillable = [
        'kiotviet_employee_id',
        'month',
        'year',
        'points'
    ];

    /**
     * Mối quan hệ: KPI thuộc về một nhân viên.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'kiotviet_employee_id', 'kiotviet_id');
    }

    /**
     * Cập nhật điểm KPI nhân viên theo đánh giá hóa đơn.
     */
    public static function updateKpiScore($employeeId, $rating)
    {
        $month = now()->month;
        $year = now()->year;

        // Xác định điểm thay đổi dựa trên số sao
        $pointsChange = 0;
        switch ($rating) {
            case 5:
                $pointsChange = 3;
                break;
            case 4:
                $pointsChange = 1;
                break;
            case 3:
                $pointsChange = -3;
                break;
            case 2:
                $pointsChange = -7;
                break;
            case 1:
                $pointsChange = -12;
                break;
        }

        // Tìm hoặc tạo mới KPI nhân viên
        $employeeKpi = self::firstOrCreate(
            ['kiotviet_employee_id' => $employeeId, 'month' => $month, 'year' => $year],
            ['points' => 70] // Điểm KPI mặc định nếu mới tạo
        );

        // Cập nhật điểm KPI
        $newPoints = max(30, min(120, $employeeKpi->points + $pointsChange));
        $employeeKpi->update(['points' => $newPoints]);

        return $employeeKpi;
    }
}
