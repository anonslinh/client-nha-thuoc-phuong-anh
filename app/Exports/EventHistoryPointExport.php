<?php

namespace App\Exports;

use App\Models\HistoryPointEvent;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EventHistoryPointExport implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = HistoryPointEvent::query()
            ->join('customers', 'customers.id', '=', 'history_point_event.customer_id')
            ->select(
                'history_point_event.*',
                'customers.name as name_customer',
                'customers.code as code_customer',
                'customers.contact_number as phone_customer'
            );

        // Ví dụ lọc theo khoảng thời gian
        if ($this->request->filled('from_date')) {
            $query->whereDate('history_point_event.created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('history_point_event.created_at', '<=', $this->request->to_date);
        }

        return $query->orderBy('history_point_event.created_at', 'desc')->get()->map(function ($item) {
            return [
                'code'  => $item->code_customer,
                'name'  => $item->name_customer,
                'phone' => $item->phone_customer,
                'order_code' => $item->code_order,
                'product_code' => $item->product_code,
                'product_name' => $item->product_name,
                'title' => $item->title,
                'point' => $item->point,
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
            'Mã ĐH',
            'MÃ Sản Phẩm',
            'Tên Sản Phẩm',
            'Tiêu Đề',
            'Điểm',
            'Ngày Giờ'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 30,
            'G' => 30,
            'H' => 10,
            'I' => 15
        ];
    }
}

