<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceRequest extends Model
{
    protected $fillable = [
        'invoice_id',
        'invoice_code',
        'type',
        'status',
        'result_url',
        'name',
        'phone',
        'address',
        'email',
        'note',
        'tax_code',
        'company_name',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
