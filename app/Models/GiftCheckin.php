<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCheckin extends Model
{
    use HasFactory;
    protected $table = 'gift_checkin';
    protected $fillable = [
        'title',
        'code',
        'image',
        'percent'
    ];
}
