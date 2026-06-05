<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemV1 extends Model
{
    protected $table = 'order_item_v1';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(OrderV1::class, 'id_order_v1', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductV1::class, 'id_product_v1', 'id');
    }
}