<?php

namespace App\Exports;

use App\Models\GiftExchanges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CustomerExchangeGiftExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = GiftExchanges::query()
                ->join('customers', 'customers.kiotviet_id', '=', 'gift_exchanges.customer_id')
                ->join('gifts', 'gifts.id', '=','gift_exchanges.gift_id')
                ->select('gift_exchanges.*','customers.name as name_customer', 'gifts.name', 'gifts.code', 'gifts.image');

        return $query->orderBy('customers.created_at', 'desc')->get()->map(function ($item) {
            if ($item->status == 'pending'){
                $status = 'Chưa Nhận Quà';
            }elseif ($item->status == 'completed'){
                $status = 'Đã nhận quà';
            }else{
                $status = 'Đã hủy';
            }
            return [
                $item->name_customer,
                $item->contact_phone,
                $item->name,
                $item->code,
                $item->points_used,
                $status,
                date_format(date_create($item->created_at), 'H:i d/m/Y')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tên KH',
            'SĐT KH',
            'Tên Quà Tặng',
            'Mã Quà Tặng',
            'Điểm',
            'Trạng thái',
            'Ngày Giờ'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 30,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 20,
        ];
    }
}

