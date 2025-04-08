<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftRotationQuantity extends Model
{
    use HasFactory;
    protected $table = 'gift_rotation_quantity';
    protected $fillable = [
        'gift_rotation_id',
        'branches_id',
        'quantity'
    ];
}
