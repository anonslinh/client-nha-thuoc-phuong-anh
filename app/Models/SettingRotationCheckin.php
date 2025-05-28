<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingRotationCheckin extends Model
{
    protected $fillable = [
        'title',
        'time_start',
        'time_end',
        'logo',
        'background',
        'rotation',
        'color_button',
        'color_gift'
    ];
}
