<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuantityGiftEvents extends Model
{
    protected $table = 'quantity_gift_events';
    protected $fillable = [
        'gift_events_id',
        'branch_id',
        'quantity'
    ];
}
