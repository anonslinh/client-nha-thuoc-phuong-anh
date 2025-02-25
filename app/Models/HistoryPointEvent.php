<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryPointEvent extends Model
{
    protected $table = 'history_point_event';
    protected $fillable = [
        'customer_id',
        'title',
        'code_order',
        'product_id',
        'product_name',
        'product_code',
        'point',
        'type'
    ];
}
