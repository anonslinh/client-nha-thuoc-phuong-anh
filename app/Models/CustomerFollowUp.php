<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_number',
        'invoice_id',
        'schedule_date',
        'note',
        'status',
        'called_at',
        'result_note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'kiotviet_id');
    }
}
