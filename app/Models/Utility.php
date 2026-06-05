<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_room',
        'name',
        'icon',
        'short_desc',
        'status',
    ];

    protected $casts = [
        'id_room' => 'integer',
        'status'  => 'integer',
    ];
}
