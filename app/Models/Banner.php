<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'title',
        'image_url',
        'redirect_url',
        'status',
        'start_date',
        'end_date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'kiotviet_id');
    }

    // Accessor lấy tên chi nhánh
    public function getBranchNameAttribute()
    {
        return $this->branch ? ($this->branch->branch_name ?? 'Không xác định') : 'Toàn hệ thống';
    }
}
