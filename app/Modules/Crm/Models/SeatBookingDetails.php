<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class SeatBookingDetails extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function seatBooking()
    {
        return $this->belongsTo(SeatBooking::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
