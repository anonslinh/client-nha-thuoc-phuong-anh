<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\ExchangeGiftEvent;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EventHistoryExchangeGiftExport implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = ExchangeGiftEvent::query()
            ->join('customers', 'customers.id', '=', 'exchange_gift_event.customer_id')
            ->select('exchange_gift_event.*', 'customers.name', 'customers.code', 'customers.contact_number');

        // Ví dụ lọc theo khoảng thời gian
        if ($this->request->filled('from_date')) {
            $query->whereDate('exchange_gift_event.created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('exchange_gift_event.created_at', '<=', $this->request->to_date);
        }

        return $query->orderBy('exchange_gift_event.created_at', 'desc')->get()->map(function ($item) {
            $branch = Branch::where('kiotviet_id', $item->branch_id)->first();
            $value['name_branch'] = $branch->branch_name ?? '';
            if ($item->status == 2){
                $status = 'Đã đổi quà';
            }elseif ($item->status == 3){
                $status = 'Hủy';
            }else{
                $status = 'Chưa đổi quà';
            }
            return [
                'code'  => $item->code,
                'name'  => $item->name,
                'phone' => $item->contact_number,
                'name_gift' => $item->name_gift,
                'code_gift' => $item->code_gift,
                'point' => $item->point,
                'branch_name' => $branch->branch_name ?? '',
                'status' => $status,
                'time' => date_format(date_create($item->created_at), 'H:i d/m/Y')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã KH',
            'Tên KH',
            'SĐT KH',
            'Tên Quà Tặng',
            'MÃ Quà Tặng',
            'Điểm',
            'Chi Nhánh',
            'Trạng thái',
            'Ngày giờ'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 15,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 10,
            'I' => 15
        ];
    }
}

