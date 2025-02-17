<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'description', 'start_date', 'end_date', 'apply_to', 'image_path', 'join_link', 'active_join_link', 'status', 'priority'];

}
