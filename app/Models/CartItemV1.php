<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemV1 extends Model
{
    protected $table = 'cart_item_v1';

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(CartV1::class, 'id_cart_v1', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductV1::class, 'id_product_v1', 'id');
    }
}