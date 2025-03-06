<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'branch_id',
        'thumbnail',
        'images',
        'join_link',
        'active_join_link',
        'status',
        'start_date',
        'end_date',
        'priority'
    ];

    protected $casts = [
        'images' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'active_join_link' => 'boolean'
    ];

    /**
     * Quan hệ với bảng chi nhánh (Branch)
     */
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
