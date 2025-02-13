<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessTokens extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token_code', 'access_token', 'expires_at'
    ];
}
