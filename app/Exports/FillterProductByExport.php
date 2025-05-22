<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FillterProductByExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $listData;

    public function __construct($listData)
    {
        $this->listData = $listData;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = $this->listData;
        return $data->map(function ($value) {
            return [
                $value->customer_code."\n".$value->customer_name."\n".$value->contact_number,
                $value->product_name."\n"."SKU: ".$value->product_code,
                $value->branch_name."\n".$value->code."\n"."SL: ".$value->quantity,
                $value->purchase_date,
                "Đã mua: $value->days_since_purchase ngày"
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Khách hàng',
            'Sản phẩm',
            'Đơn hàng',
            'Ngày mua',
            'Đã mua'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 60,
            'C' => 50,
            'D' => 20,
            'E' => 20,
        ];
    }
}
