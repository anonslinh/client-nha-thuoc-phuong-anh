<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomDayStatus extends Model
{
    protected $fillable = ['room_id','date','status','price','booking_id','note','total_qty','hold_qty','booked_qty'];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'total_qty' => 'integer',
        'hold_qty' => 'integer',
        'booked_qty' => 'integer',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
