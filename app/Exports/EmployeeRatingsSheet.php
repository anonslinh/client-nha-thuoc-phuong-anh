<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class EmployeeRatingsSheet implements FromCollection, WithTitle, WithColumnWidths
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        // Dữ liệu cột tiêu đề
        $data = collect([
            ["Mã hóa đơn", "Ngày tạo", "Số sao", "Ghi chú"]
        ]);

        // Dữ liệu chi tiết đánh giá
        $ratings = $this->query->get()->map(function ($rating) {
            return [
                $rating->invoice->code ?? '',
                $rating->created_at->format('H:i d/m/Y'),
                $rating->rating,
                $rating->comment ?? '',
            ];
        });

        return $data->merge($ratings);
    }

    public function title(): string
    {
        return 'Chi tiết đánh giá';
    }

    /**
     * Định nghĩa độ rộng cột trong file Excel
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Mã hóa đơn
            'B' => 20, // Ngày tạo đánh giá
            'C' => 8, // Số sao
            'D' => 100, // Nội dung đánh giá (comment) rộng hơn
        ];
    }
}
