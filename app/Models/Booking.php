<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'code','customer_name','phone','email',
        'check_in_date','check_out_date',
        'adults','children',
        'status','payment_status',
        'deposit_amount','total_amount','paid_amount',
        'note',
    ];

    protected $casts = [
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
        'deposit_amount' => 'decimal:2',
        'total_amount'   => 'decimal:2',
        'paid_amount'    => 'decimal:2',
    ];

    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms');
    }
}
