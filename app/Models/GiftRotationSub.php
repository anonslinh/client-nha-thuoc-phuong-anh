<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftRotationSub extends Model
{
    use HasFactory;

    protected $table = 'gift_rotation_2';
    protected $fillable = [
        'rule_rotation_id',
        'title',
        'code',
        'image',
        'quantity',
        'percent'
    ];
}
