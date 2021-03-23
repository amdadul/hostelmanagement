<?php

namespace App\Modules\Crm\Models;

use App\Modules\Accounts\Models\Advance;
use App\Modules\Accounts\Models\ServiceCharge;
use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    protected $guarded = [];

    public function maxSlNo(){
        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function service_charge()
    {
        return $this->belongsTo(ServiceCharge::class);
    }

    public function advance()
    {
        return $this->belongsTo(Advance::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seatBookingDetails()
    {
        return $this->hasMany(SeatBookingDetails::class);
    }
}
