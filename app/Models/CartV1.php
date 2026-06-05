<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartV1 extends Model
{
    protected $table = 'cart_v1';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(CartItemV1::class, 'id_cart_v1', 'id');
    }
}