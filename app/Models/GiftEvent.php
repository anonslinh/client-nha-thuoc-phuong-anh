<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftEvent extends Model
{
    protected $table = 'gift_event';
    protected $fillable = [
        'name',
        'image',
        'code',
        'barcode',
        'point',
        'quantity',
        'active',
        'description'
    ];
}
