<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    protected $guarded = [];

    public function seat()
    {
        $this->belongsTo(Seat::class);
    }

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }
}
