<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\HistoryGiftRotation;
use App\Models\HistoryInvoiceRotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class HistoryCustomerExchangeGift implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $listData = HistoryGiftRotation::orderBy('created_at', 'desc')->get();
        foreach ($listData as $value){
            $invoiceRotation = HistoryInvoiceRotation::find($value->history_invoice_rotation_id);
            $branch = Branch::where('kiotviet_id', $invoiceRotation->branch_id)->first();
            $value['invoice_code'] = $invoiceRotation->invoice_code;
            $value['branch_name'] = $branch->branch_name??'';
        }
        return $listData->map(function ($item) {
                return [
                    'name_customer'     => $item->name_customer,
                    'phone_customer'     => $item->phone_customer,
                    'name_gift' => $item->name_gift,
                    'code_gift'        => $item->code_gift,
                    'code_invoice' => $item->invoice_code,
                    'name_branch' => $item->branch_name,
                    'time' => date_format(date_create($item->created_at), 'H:i d/m/Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Số điện thoại',
            'Tên quà',
            'Mã quà',
            'Hóa đơn',
            'Chi Nhánh',
            'Thời Gian'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 60,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
        ];
    }
}

