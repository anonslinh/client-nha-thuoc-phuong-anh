<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\HistoryPointEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CustomerExport implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = Customer::query()
            ->leftJoin('invoices', 'customers.kiotviet_id', '=', 'invoices.customer_id')
            ->select(
                'customers.id', 'customers.code', 'customers.name', 'customers.contact_number',
                'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points','customers.reward_point',
                DB::raw('COUNT(invoices.id) as total_orders') // Tổng số đơn hàng trong ngày
            )
            ->groupBy('customers.id', 'customers.code', 'customers.name', 'customers.contact_number',
                'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points', 'customers.reward_point');

        return $query->orderBy('customers.created_at', 'desc')->get()->map(function ($item) {
            return [
                'code'  => $item->code,
                'name'  => $item->name,
                'phone'  => $item->contact_number,
                'total_invoice' => $item->total_revenue,
                'total_order' => $item->total_orders,
                'point_kiotviet' => $item->kiotviet_reward_point - $item->used_points,
                'point' => $item->reward_point,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã KH',
            'Tên KH',
            'SĐT KH',
            'Tổng chi tiêu',
            'Tổng đơn hàng',
            'Điểm kiotviet',
            'Điểm hệ thống',
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
            'F' => 20,
            'G' => 20,
        ];
    }
}

