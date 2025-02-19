<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiotviet_id',
        'code',
        'name',
        'contact_number',
        'address',
        'retailer_id',
        'branch_id',
        'location_name',
        'ward_name',
        'modified_date',
        'created_date',
        'type',
        'organization',
        'debt',
        'total_invoiced',
        'total_revenue',
        'total_point',
        'reward_point',
        'kiotviet_reward_point',
        'used_points',
        'review_count'
    ];
}
