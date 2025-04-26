<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotationCheckin extends Model
{
    use HasFactory;
    protected $table = 'rotation_checkin';
    protected $fillable = [
        'phone',
        'image',
        'branch_id',
        'use'
    ];
}
