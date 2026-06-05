<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'price_listed',
        'img_avatar',
        'img_banner',
        'link_video',
        'note_services',
        'type',
        'description',
        'is_active',
        'status',
        'number_rooms',
    ];

    protected $casts = [
        'price'=>'integer','price_listed'=>'integer','type'=>'integer',
        'is_active'=>'integer','status'=>'integer','number_rooms'=>'integer', // <---
    ];
}
