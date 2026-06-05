<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $fillable = [
        'id_room',
        'name',
        'image',
        'short_desc',
        'status',
    ];

    protected $casts = [
        'id_room' => 'integer',
        'status'  => 'integer',
    ];
}
