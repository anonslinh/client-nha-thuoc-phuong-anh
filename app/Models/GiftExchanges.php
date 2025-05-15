<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GiftExchanges extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_phone',
        'gift_id',
        'branch_id',
        'exchange_code',
        'points_used',
        'exchange_date',
        'status',
        'notes',
        'gift_name',
        'gift_code'
    ];

    // Quan hệ với bảng Gifts
    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }

    // Quan hệ với bảng Branches
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // Hàm lấy báo cáo theo tháng và chi nhánh
    public static function getMonthlyReport($month, $year, $branchId = null)
    {
        $query = self::select(
            DB::raw('MONTH(exchange_date) as month'),
            DB::raw('YEAR(exchange_date) as year'),
            DB::raw('COUNT(id) as total_exchanges'),
            DB::raw('SUM(points_used) as total_points_used')
        )
            ->whereYear('exchange_date', $year)
            ->whereMonth('exchange_date', $month)
            ->where('status', 'completed');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        return $query->groupBy('month', 'year')->first();
    }
}
