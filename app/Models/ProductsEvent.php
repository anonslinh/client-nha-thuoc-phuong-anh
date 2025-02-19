<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsEvent extends Model
{
    protected $table = 'products_event';
    protected $fillable = [
        'events_id',
        'product_id',
        'product_code',
        'name',
        'images',
        'base_price',
        'price',
        'point',
        'is_active'
    ];
}
