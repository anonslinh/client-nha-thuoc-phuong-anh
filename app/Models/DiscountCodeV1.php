<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeV1 extends Model
{
    protected $table = 'discount_codes_v1';

    protected $guarded = [];

    const TYPE_VOUCHER = 1;
    const TYPE_COUPON = 2;

    const DISCOUNT_TYPE_PERCENT = 1;
    const DISCOUNT_TYPE_FIXED = 2;

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('quantity')->orWhereColumn('used_count', '<', 'quantity');
            });
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < (float) $this->min_order_amount) {
            return 0;
        }

        if ((int) $this->discount_type === self::DISCOUNT_TYPE_FIXED) {
            $amount = (float) $this->discount_value;
        } else {
            $amount = $subtotal * ((float) $this->discount_value / 100);

            if (!empty($this->max_discount_amount) && $amount > (float) $this->max_discount_amount) {
                $amount = (float) $this->max_discount_amount;
            }
        }

        return min($amount, $subtotal);
    }
}
