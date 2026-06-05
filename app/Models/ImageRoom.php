<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageRoom extends Model
{
    use HasFactory;

    protected $table = 'images_room';

    protected $fillable = [
        'id_room',
        'link_image',
        'sort_order',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'id_room'     => 'integer',
        'sort_order'  => 'integer',
        'is_featured' => 'integer',
        'status'      => 'integer',
    ];
}
