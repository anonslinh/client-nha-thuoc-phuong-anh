<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'description', 'start_date', 'end_date', 'apply_to', 'image_path', 'join_link', 'active_join_link', 'status', 'priority'];

    /**
     * Quan hệ với bảng chi nhánh (Branch)
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'apply_to', 'kiotviet_id');
    }

    // Accessor lấy tên chi nhánh
    public function getBranchNameAttribute()
    {
        return $this->branch ? ($this->branch->branch_name ?? 'Không xác định') : 'Toàn hệ thống';
    }
}
