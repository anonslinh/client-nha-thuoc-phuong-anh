<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromView, WithColumnWidths, ShouldAutoSize
{
    public function view(): View
    {
        $month = now()->month;
        $year = now()->year;

        $listData = Employee::query()
            ->leftJoin('employee_kpis', function ($join) use ($month, $year) {
                $join->on('employees.kiotviet_id', '=', 'employee_kpis.kiotviet_employee_id')
                    ->where('employee_kpis.month', $month)
                    ->where('employee_kpis.year', $year);
            })
            ->leftJoin('employee_rating_summaries', function ($join) use ($month, $year) {
                $join->on('employees.kiotviet_id', '=', 'employee_rating_summaries.employee_id')
                    ->where('employee_rating_summaries.month', $month)
                    ->where('employee_rating_summaries.year', $year);
            })
            ->select(
                'employees.user_name',
                'employees.given_name',
                \DB::raw('COALESCE(employee_kpis.points, 70) as kpi_points'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_1, 0) + COALESCE(employee_rating_summaries.rating_2, 0) + COALESCE(employee_rating_summaries.rating_3, 0) as low_ratings'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_1, 0) as rating_1'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_2, 0) as rating_2'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_3, 0) as rating_3'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_4, 0) as rating_4'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_5, 0) as rating_5')
            )
            ->orderBy('kpi_points', 'asc') // Sắp xếp điểm từ thấp đến cao
            ->get();

        return view('exports.employees', compact('listData'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // Tài khoản
            'B' => 30, // Họ tên
            'C' => 20, // Điểm số
            'D' => 20, // Đánh giá nguy hiểm
            'E' => 10, // 1 sao
            'F' => 10, // 2 sao
            'G' => 10, // 3 sao
            'H' => 10, // 4 sao
            'I' => 10, // 5 sao
        ];
    }
}
