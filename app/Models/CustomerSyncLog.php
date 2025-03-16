<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSyncLog extends Model
{
    use HasFactory;

    protected $table = 'customer_sync_logs';

    protected $fillable = [
        'phone',
        'personal_access_token',
        'kiotviet_id',
        'total_invoiced',
        'total_revenue',
        'total_point',
        'reward_point',
    ];
    public function personalAccessToken()
    {
        return $this->hasOne(PersonalAccessTokens::class, 'access_token_code', 'personal_access_token');
    }
}
