<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'product_id', 'product_code', 'product_name', 'category_id', 'category_name',
        'trade_mark_id', 'trade_mark_name', 'quantity', 'price', 'discount', 'use_point',
        'sub_total', 'serial_numbers', 'return_quantity'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
