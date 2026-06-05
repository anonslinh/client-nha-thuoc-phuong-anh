<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItemV1 extends Model
{
    protected $table = 'flash_sale_items_v1';
    protected $guarded = [];
    protected $fillable = [
    'flash_sale_id',
    'product_id',
    'item_name',
    'item_image',
    'flash_price',
    'quantity',
    'sold',
    'status',
];
}