<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherExchanges extends Model
{

    protected $table = 'voucher_exchanges';

    protected $fillable = [
        'customer_id',
        'voucher_id',
        'branch_id',
        'exchange_code',
        'points_used',
        'exchange_date',
        'status',
        'notes',
        'discount_amount',
        'contact_phone',
        'account_code',
        'release_code',
        'voucher_campaign_id'
    ];

    // Định nghĩa quan hệ đúng (số ít)
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
