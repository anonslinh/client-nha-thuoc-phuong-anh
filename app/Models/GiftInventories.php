<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftInventories extends Model
{
    use HasFactory;

    protected $fillable = [
        'gift_id',
        'branch_id',
        'quantity',
    ];

    // Quan hệ với bảng Gifts
    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }

    // Quan hệ với bảng Branches
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
