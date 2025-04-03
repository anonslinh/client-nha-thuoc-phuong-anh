<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGiftModel extends Model
{
    use HasFactory;
    protected $table = 'product_gift';
    protected $fillable = [
        'products_id',
        'gifts_id'
    ];
}
