<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBranches extends Model
{
    use HasFactory;

    protected $table = 'account_branches';

    protected $fillable = [
        'name',
        'code',
        'retailer',
        'client_id',
        'client_secret',
        'active',
    ];
}
