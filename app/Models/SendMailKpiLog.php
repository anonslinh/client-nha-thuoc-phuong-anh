<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMailKpiLog extends Model
{
    use HasFactory;

    protected $table = 'send_mail_kpi_logs';

    protected $fillable = [
        'kiotviet_employee_id',
        'sent_at',
    ];

    public $timestamps = true;
}
