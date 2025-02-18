<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRank extends Model
{
    use HasFactory;

    protected $table = 'customer_ranks';

    protected $fillable = [
        'customer_id',
        'current_rank',
        'rank_start_date',
        'rank_end_date',
    ];
}
