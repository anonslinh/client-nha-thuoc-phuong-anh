<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiotviet_id', 'branch_name', 'address', 'location_name',
        'ward_name', 'contact_number', 'retailer_id',
        'email', 'modified_date', 'created_date', 'account_code', 'is_active'
    ];
}
