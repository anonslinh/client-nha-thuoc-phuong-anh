<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'discount_amount',
        'required_points',
        'expiry_date',
        'applicable_products',
        'points_required',
        'membership_levels_id',
        'release_code'
    ];

    protected $casts = [
        'applicable_products' => 'array', // Chuyển đổi JSON thành mảng PHP
    ];

    public function exchanges()
    {
        return $this->hasMany(VoucherExchanges::class, 'voucher_id');
    }
}
