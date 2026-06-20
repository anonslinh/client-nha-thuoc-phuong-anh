<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class WebsiteCustomerV1 extends Authenticatable
{
    protected $table = 'website_customers_v1';

    protected $guarded = [];

    protected $hidden = [
        'remember_token',
    ];

    /**
     * Đăng nhập bằng OTP, không có mật khẩu.
     */
    public function getAuthPassword()
    {
        return '';
    }
}
