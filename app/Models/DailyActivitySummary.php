<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyActivitySummary extends Model
{
    protected $table = 'daily_activity_summaries';

    protected $fillable = [
        'customer_kiotviet_id',
        'date',
        'action',
        'count',
    ];

    public $timestamps = true;

    /**
     * Cập nhật số lượt truy cập của khách hàng
     * DailyActivitySummary::logAction($customer['id'] ?? null, 'view_points'); //Ghi log đếm số lượng truy cập xem điểm
     * DailyActivitySummary::logAction($customer->kiotviet_id ?? null, 'access_to'); //Ghi log đếm số lượng truy cập ứng dụng
     * DailyActivitySummary::logAction($customerId, 'redeem_gift_voucher'); //Ghi log đếm số lượng đổi quà đổi voucher
     * DailyActivitySummary::logAction($customerId, 'rate'); //Ghi log đếm số lượng đánh giá đơn hàng
     * DailyActivitySummary::logAction($customerId, 'feedback'); //Ghi log đếm số lượng truy cập liên hệ & phản hồi
     */
    public static function logAction($customerId, $action)
    {
        $date = now()->toDateString();

        return static::updateOrCreate(
            [
                'customer_kiotviet_id' => $customerId,
                'date' => $date,
                'action' => $action,
            ],
            [
                'count' => \DB::raw('count + 1')
            ]
        );
    }
}
