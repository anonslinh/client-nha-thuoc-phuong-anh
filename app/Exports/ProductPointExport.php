<?php

namespace App\Exports;

use App\Models\ProductPoint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProductPointExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ProductPoint::select('code', 'name', 'point')
            ->get()
            ->map(function ($item) {
                return [
                    'code'     => $item->code,
                    'name'     => $item->name,
                    'point' => $item->point,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Mã sản phẩm',
            'Tên sản phẩm',
            'Điểm',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 60,
            'C' => 30,
        ];
    }
}

