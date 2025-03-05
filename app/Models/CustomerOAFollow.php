<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOAFollow extends Model
{

    use HasFactory;

    protected $table = 'customer_oa_follows';

    protected $fillable = [
        'phone',
        'oa_id',
    ];
}
