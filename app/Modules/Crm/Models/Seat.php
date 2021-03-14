<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $guarded = [];

    public function room()
    {
        $this->belongsTo(Room::class);
    }

    public function seatPrice()
    {
        $this->hasMany(SeatPrice::class);
    }

    public function seatBooking()
    {
        $this->hasMany(SeatBooking::class);
    }

    public function invoiceDetails()
    {
        $this->hasMany(InvoiceDetails::class);
    }

    public function advance()
    {
        $this->hasMany(Advance::class);
    }

    public function serviceCharge()
    {
        $this->hasMany(ServiceCharge::class);
    }

    public function moneyReceipt()
    {
        $this->hasMany(MoneyReceipt::class);
    }
}
