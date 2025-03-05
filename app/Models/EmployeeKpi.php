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
    public static function updateKpiScore($employeeId, $rating, $kpiConfig)
    {
        $month = now()->month;
        $year = now()->year;

        // Xác định điểm thay đổi dựa trên số sao
        $pointsChange = 0;
        switch ($rating) {
            case 5:
                $pointsChange = $kpiConfig->star_5;
                break;
            case 4:
                $pointsChange = $kpiConfig->star_4;
                break;
            case 3:
                $pointsChange = $kpiConfig->star_3;
                break;
            case 2:
                $pointsChange = $kpiConfig->star_2;
                break;
            case 1:
                $pointsChange = $kpiConfig->star_1;
                break;
        }

        // Tìm hoặc tạo mới KPI nhân viên
        $employeeKpi = self::firstOrCreate(
            ['kiotviet_employee_id' => $employeeId, 'month' => $month, 'year' => $year],
            ['points' => $kpiConfig->default_kpi] // Điểm KPI mặc định nếu mới tạo
        );

        // Cập nhật điểm KPI
        $newPoints = max($kpiConfig->min_kpi, min($kpiConfig->max_kpi, $employeeKpi->points + $pointsChange));
        $employeeKpi->update(['points' => $newPoints]);

        return $employeeKpi;
    }
}
