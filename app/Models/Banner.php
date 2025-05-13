<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'title',
        'image_url',
        'redirect_url',
        'status',
        'start_date',
        'end_date',
    ];
}
