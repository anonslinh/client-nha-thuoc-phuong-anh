<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionRequestV1 extends Model
{
    protected $table = 'prescription_requests_v1';

    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}