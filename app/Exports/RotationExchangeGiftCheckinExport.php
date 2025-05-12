<?php

namespace App\Exports;

use App\Models\CustomerGiftCheckin;
use App\Models\HistoryPointEvent;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class RotationExchangeGiftCheckinExport implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = CustomerGiftCheckin::query();

        // Ví dụ lọc theo khoảng thời gian
        if ($this->request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $this->request->to_date);
        }

        return $query->orderBy('created_at', 'desc')->get()->map(function ($item) {
            return [
                $item->phone,
                $item->gift_code,
                $item->gift_name,
                $item->branch_name,
                date_format(date_create($item->created_at), 'H:i d/m/Y')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SĐT KH',
            'MÃ Quà Tặng',
            'Tên Quà Tặng',
            'Chi Nhánh',
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
        ];
    }
}

