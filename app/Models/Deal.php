<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount',
        'fixed_price',
        'start_time',
        'end_time',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(DealProduct::class);
    }

    public function inventories()
    {
        return $this->hasMany(DealInventory::class);
    }
}
