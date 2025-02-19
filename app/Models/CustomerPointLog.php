<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPointLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiotviet_id',
        'used_points',
        'note',
    ];

    /**
     * Cập nhật điểm đã sử dụng của khách hàng (có thể cộng hoặc trừ).
     *
     * @param int $kiotvietId - ID khách hàng trong KiotViet
     * @param int $points - Số điểm thay đổi
     * @param string $type - Loại thay đổi ('increase' hoặc 'decrease')
     */
    public static function updateUsedPoints($kiotvietId, $points, $type = 'increase')
    {
        $operation = ($type === 'increase') ? '+' : '-';

        // Cập nhật hoặc tạo mới bản ghi điểm đã sử dụng của khách hàng
        return self::updateOrInsert(
            ['kiotviet_id' => $kiotvietId],
            ['used_points' => \DB::raw("GREATEST(0, used_points $operation $points)")]
        );
    }

}
