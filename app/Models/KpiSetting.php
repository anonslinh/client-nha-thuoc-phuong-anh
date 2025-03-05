<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_kpi', 'min_kpi', 'max_kpi',
        'star_1', 'star_2', 'star_3', 'star_4', 'star_5',
        'orders_required', 'min_order_value', 'reward_points', 'cutoff_date'
    ];

}
