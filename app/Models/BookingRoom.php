<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    protected $fillable = ['booking_id','room_id','qty','price_per_night','amount'];

    protected $casts = [
        'qty' => 'integer',
        'price_per_night' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
