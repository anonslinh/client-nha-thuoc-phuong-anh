<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiotviet_id', 'uuid', 'code', 'purchase_date', 'branch_id', 'branch_name', 'sold_by_id', 'sold_by_name',
        'customer_id', 'customer_code', 'customer_name', 'order_code', 'total', 'total_payment',
        'discount', 'status', 'status_value', 'using_cod', 'description', 'created_date'
    ];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
