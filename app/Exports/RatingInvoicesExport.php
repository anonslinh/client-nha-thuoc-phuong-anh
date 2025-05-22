<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class RatingInvoicesExport implements FromCollection, WithHeadings, WithColumnWidths
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
        return $data->map(function ($item) {
            return [
                $item->invoice->code." - ".number_format($item->invoice->total_payment)."đ"."\n".$item->invoice->customer_name."\n".$item->invoice->contact_number,
                $item->invoice->sold_by_name."\n".$item->invoice->branch_name,
                $item->rating."\n".$item->created_at->format('H:i d/m/Y'),
                $item->comment,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Khách hàng',
            'Nhân viên',
            'Sao',
            'Nội dung'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 25,
            'D' => 60,
        ];
    }

}
