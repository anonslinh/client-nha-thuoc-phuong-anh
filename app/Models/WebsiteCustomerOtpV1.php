<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCustomerOtpV1 extends Model
{
    protected $table = 'website_customer_otps_v1';

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
}
