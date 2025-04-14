<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCertificate extends Model
{
    protected $fillable = [
        'product_name', 'product_code', 'certificate_link', 'is_active'
    ];
}
