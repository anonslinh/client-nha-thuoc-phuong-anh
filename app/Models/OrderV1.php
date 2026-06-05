<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderV1 extends Model
{
    protected $table = 'order_v1';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItemV1::class, 'id_order_v1', 'id');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLogV1::class, 'id_order_v1', 'id');
    }

    public function syncLogs()
    {
        return $this->hasMany(OrderSyncKiotvietLogV1::class, 'id_order_v1', 'id');
    }
}