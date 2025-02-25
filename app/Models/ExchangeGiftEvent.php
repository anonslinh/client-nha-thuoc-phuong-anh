<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeGiftEvent extends Model
{
    protected $table = 'exchange_gift_event';
    protected $fillable = [
        'customer_id',
        'gift_id',
        'name_gift',
        'image_gift',
        'code_gift',
        'barcode_gift',
        'point',
        'quantity',
        'status'
    ];
}
