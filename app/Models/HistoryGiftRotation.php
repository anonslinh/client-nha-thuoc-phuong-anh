<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryGiftRotation extends Model
{
    use HasFactory;
    protected $table = 'history_gift_rotation';
    protected $fillable = [
        'customer_id',
        'name_customer',
        'phone_customer',
        'history_invoice_rotation_id',
        'name_gift',
        'image_gift',
        'code_gift',
        'status'
    ];
}
