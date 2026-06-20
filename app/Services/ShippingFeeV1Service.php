<?php

namespace App\Services;

use App\Models\ShippingFeeRuleV1;

class ShippingFeeV1Service
{
    public function calculate(float $subtotal): array
    {
        $rule = ShippingFeeRuleV1::query()
            ->where('is_active', 1)
            ->where('min_amount', '<=', $subtotal)
            ->where(function ($q) use ($subtotal) {
                $q->whereNull('max_amount')->orWhere('max_amount', '>=', $subtotal);
            })
            ->orderBy('min_amount', 'desc')
            ->first();

        $fee = $rule ? (float) $rule->fee : 0;

        return [
            'fee' => $fee,
            'label' => $fee <= 0 ? 'Miễn phí vận chuyển' : number_format($fee, 0, ',', '.') . 'đ',
            'rule_id' => $rule->id ?? null,
        ];
    }
}
