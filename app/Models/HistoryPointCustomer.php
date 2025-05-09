<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPointCustomer extends Model
{
    use HasFactory;
    protected $table = 'history_point_customer';
    protected $fillable = [
        'phone_customer',
        'name_customer',
        'order_code',
        'title',
        'point',
        'order_id',
        'created_at'
    ];
}
