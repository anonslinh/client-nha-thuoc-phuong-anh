<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRankModel extends Model
{
    use HasFactory;
    protected $table = 'type_rank';
    protected $fillable = [
        'type',
        'time'
    ];
}
