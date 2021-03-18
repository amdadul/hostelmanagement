<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function seatPrices()
    {
        return $this->hasMany(SeatPrice::class,'seat_id','id');
    }

    public function seatPrice()
    {
        return $this->hasOne(SeatPrice::class,'seat_id','id')->latest();
    }

    public function seatBooking()
    {
        return $this->hasMany(SeatBooking::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class);
    }

    public function advance()
    {
        return $this->hasMany(Advance::class);
    }

    public function serviceCharge()
    {
        return $this->hasMany(ServiceCharge::class);
    }

    public function moneyReceipt()
    {
        return $this->hasMany(MoneyReceipt::class);
    }
}
