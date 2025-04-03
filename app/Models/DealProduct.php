<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'product_id',
        'store_id',
        'stock_quantity',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function product()
    {
        return $this->belongsTo(DealProduct::class, 'product_id');
    }

    public function store()
    {
        return $this->belongsTo(Branch::class);
    }
}
