<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGiftCheckin extends Model
{
    use HasFactory;
    protected $table = 'customer_gift_checkin';
    protected $fillable = [
        'phone',
        'gift_name',
        'gift_code',
        'gift_image',
        'branch_name',
        'branch_id'
    ];
}
