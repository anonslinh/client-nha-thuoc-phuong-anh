<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryInvoiceRotation extends Model
{
    use HasFactory;
    protected $table = 'history_invoice_rotation';
    protected $fillable = [
        'invoice_code',
        'customer_id',
        'rule_rotation_id',
        'branch_id',
        'money_invoice',
        'used'
    ];
}
