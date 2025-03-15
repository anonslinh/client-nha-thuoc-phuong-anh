<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiotviet_id',
        'account_code',
        'user_name',
        'given_name',
        'address',
        'mobile_phone',
        'retailer_id',
        'created_date',
    ];
}
