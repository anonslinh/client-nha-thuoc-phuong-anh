<?php

namespace App\Exports;

use App\Models\ProductCertificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProductCertificateExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductCertificate::select('product_name', 'product_code', 'certificate_link', 'is_active')
            ->get()
            ->map(function ($item) {
                return [
                    'product_name'     => $item->product_name,
                    'product_code'     => $item->product_code,
                    'certificate_link' => $item->certificate_link,
                    'is_active'        => $item->is_active ? 'Hiển thị' : 'Ẩn',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tên sản phẩm',
            'Mã sản phẩm',
            'Link giấy chứng nhận',
            'Trạng thái',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 60,
            'D' => 30,
        ];
    }
}

