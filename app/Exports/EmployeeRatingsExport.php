<?php

namespace App\Exports;

use App\Models\InvoiceRating;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeRatingsExport implements WithMultipleSheets
{
    protected $query;
    protected $employee;
    protected $historyData;

    public function __construct($query, $employee, $historyData)
    {
        $this->query = $query;
        $this->employee = $employee;
        $this->historyData = $historyData;
    }
    public function sheets(): array
    {
        return [
            new EmployeeSummarySheet($this->employee, $this->historyData), // 🔥 Sheet 1: Bảng KPI
            new EmployeeRatingsSheet($this->query), // 🔥 Sheet 2: Chi tiết đánh giá
        ];
    }
//
//    public function collection()
//    {
//        return $this->query->get();
//    }
//
//    public function headings(): array
//    {
//        return [
//            'Mã hóa đơn',
//            'Ngày tạo đánh giá',
//            'Số sao',
//            'Nội dung đánh giá'
//        ];
//    }
//
//    public function map($row): array
//    {
//        return [
//            $row->invoice->code ?? 'N/A', // Mã hóa đơn
//            $row->created_at->format('Y-m-d H:i:s'), // Ngày tạo đánh giá
//            $row->rating, // Số sao đánh giá
//            $row->comment ?? 'Không có nội dung' // Nội dung đánh giá (comment)
//        ];
//    }
//    /**
//     * Định nghĩa độ rộng cột trong file Excel
//     */
//    public function columnWidths(): array
//    {
//        return [
//            'A' => 15, // Mã hóa đơn
//            'B' => 15, // Ngày tạo đánh giá
//            'C' => 8, // Số sao
//            'D' => 100, // Nội dung đánh giá (comment) rộng hơn
//        ];
//    }
}
