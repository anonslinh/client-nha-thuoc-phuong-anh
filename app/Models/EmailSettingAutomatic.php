<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSettingAutomatic extends Model
{
    use HasFactory;

    protected $table = 'email_setting_automatics';

    protected $fillable = ['branch_id', 'type', 'email'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'kiotviet_id');
    }

}
