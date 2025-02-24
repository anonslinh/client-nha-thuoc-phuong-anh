<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EmployeeSummarySheet implements FromArray, WithTitle, WithColumnWidths
{
    protected $employee;
    protected $historyData;

    public function __construct($employee, $historyData)
    {
        $this->employee = $employee;
        $this->historyData = $historyData;
    }

    public function array(): array
    {
        // Hàng đầu tiên: Thông tin nhân viên
        $data = [
            ["Tên nhân viên", $this->employee->user_name],
            ["Điểm KPI hiện tại", $this->historyData['kpi_data'][5] ?? 70], // Lấy điểm mới nhất (tháng hiện tại)
            [],
        ];

        // Hàng thứ hai: Tiêu đề tháng
        $data[] = array_merge(["Tháng"], $this->historyData['months']);

        // Hàng thứ ba: Điểm KPI từng tháng
        $data[] = array_merge(["Điểm KPI"], $this->historyData['kpi_data']);

        // Hàng thứ tư: Tổng số đánh giá dưới 3 sao
        $data[] = array_merge(["Nguy hiểm"], $this->historyData['low_ratings_data']);

        return $data;
    }

    public function title(): string
    {
        return 'Tổng hợp KPI';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
        ];
    }
}
