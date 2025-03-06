<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GiftInventories extends Model
{
    use HasFactory;

    protected $fillable = [
        'gift_id',
        'branch_id',
        'quantity',
    ];

    /**
     * Quan hệ với bảng Gifts
    */
    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }

    /**
     * Quan hệ với bảng Branches
    */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Kiểm tra sản phẩm còn hàng không
     */
    public static function checkStock($giftId, $branchId, $quantity)
    {
        return self::where('gift_id', $giftId)
            ->where('branch_id', $branchId)
            ->where('quantity', '>=', $quantity)
            ->exists();
    }

    /**
     * Trừ số lượng quà tặng khi khách đổi
    */
    public static function reduceStock($giftId, $branchId, $quantity)
    {
        return DB::transaction(function () use ($giftId, $branchId, $quantity) {
            $giftStock = self::where('gift_id', $giftId)
                ->where('branch_id', $branchId)
                ->lockForUpdate() // Khoá hàng tránh lỗi race condition
                ->first();

            if (!$giftStock || $giftStock->quantity < $quantity) {
                return false; // Không đủ hàng
            }

            $giftStock->decrement('quantity', $quantity);
            return true;
        });
    }

    /**
     * Cộng lại khi khách huỷ
    */
    public static function restoreStock($giftId, $branchId, $quantity)
    {
        return DB::transaction(function () use ($giftId, $branchId, $quantity) {
            $giftInventory = self::where('gift_id', $giftId)
                ->where('branch_id', $branchId)
                ->lockForUpdate()
                ->first();

            if (!$giftInventory) {
                return false;
            }

            $giftInventory->increment('quantity', $quantity);
            return true;
        });
    }


}
