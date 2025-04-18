<?php

namespace App\Imports;

use App\Models\InvoiceRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoiceRequestsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $orderCode = $row['ma_hoa_don'] ?? $row['mã_hoá_đơn']; // hỗ trợ tên cột có dấu hoặc không
        $result_url = $row['link_hoa_don']; // hỗ trợ tên cột có dấu hoặc không

        if (!$orderCode || !$result_url){
            return null;
        }

        $invoices_request = InvoiceRequest::where('invoice_code', $orderCode)->first();
        if (!empty($invoices_request)){
            $invoices_request->update([
                'result_url' => $result_url
            ]);
        }
        return null;
    }
}
