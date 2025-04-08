<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'customer_id',
        'phone',
        'name_customer',
        'name_product',
        'code_product',
        'image_product',
        'price',
        'quantity',
        'status'
    ];
}
