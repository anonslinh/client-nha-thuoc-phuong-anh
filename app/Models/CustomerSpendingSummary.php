<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSpendingSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'month',
        'year',
        'total_spent',
        'contact_number'
    ];

    /**
     * Mối quan hệ: Một bản ghi thuộc về 1 khách hàng.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
