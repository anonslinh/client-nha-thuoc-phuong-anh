<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{

    use HasFactory;

    protected $table = 'membership_levels';

    protected $fillable = [
        'name',
        'rank',
        'spending_threshold',
    ];
}
