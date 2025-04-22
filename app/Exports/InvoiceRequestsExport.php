<?php

namespace App\Exports;

use App\Models\InvoiceRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class InvoiceRequestsExport implements FromCollection, WithHeadings, WithColumnWidths
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
        return $this->listData->map(function ($item) {
            return[
                'type' => $item->type,
                'invoice_code' => $item->invoice_code,
                'tax_code' => $item->tax_code,
                'company_name' => $item->company_name,
                'name' => $item->name,
                'phone' => $item->phone,
                'email' => $item->email,
                'address' => $item->address,
                'note' => $item->note,
                'result_url' => $item->result_url,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Loại',
            'Mã hoá đơn',
            'Mã số thuế',
            'Tên công ty',
            'Tên',
            'SĐT',
            'Email',
            'Địa chỉ',
            'Ghi chú',
            'Link hoá đơn',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,//Loại
            'B' => 12,//Mã hoá đơn
            'C' => 12,//Mã số thuế
            'D' => 35,//Tên công ty
            'E' => 15,//Tên
            'F' => 15,//SĐT
            'G' => 25,//Email
            'H' => 30,//Địa chỉ
            'I' => 40,//Ghi chú
            'J' => 60,//Link hoá đơn
        ];
    }
}
