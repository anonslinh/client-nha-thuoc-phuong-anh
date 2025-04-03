<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'deal_product_id',
        'customer_id',
        'contact_number',
        'store_id',
        'status',
        'employee_id',
        'employee_name',
        'redeemed_at',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function dealProduct()
    {
        return $this->belongsTo(DealProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function store()
    {
        return $this->belongsTo(Branch::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
