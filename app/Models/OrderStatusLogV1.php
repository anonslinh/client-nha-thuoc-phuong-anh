<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLogV1 extends Model
{
    protected $table = 'order_status_log_v1';

    public $timestamps = false;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(OrderV1::class, 'id_order_v1', 'id');
    }
}