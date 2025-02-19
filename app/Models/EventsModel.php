<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsModel extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'title',
        'description',
        'images',
        'time_start',
        'time_end',
        'is_active'
    ];
}
