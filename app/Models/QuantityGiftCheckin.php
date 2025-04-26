<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityGiftCheckin extends Model
{
    use HasFactory;
    protected $table = 'quantity_gift_checkin';
    protected $fillable = [
        'gift_checkin_id',
        'branch_id',
        'quantity'
    ];
}
