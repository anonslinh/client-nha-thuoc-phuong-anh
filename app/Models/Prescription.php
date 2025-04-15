<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'full_name', 'age', 'phone', 'address', 'image', 'note', 'status',
    ];
}
