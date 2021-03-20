<?php

namespace App\Modules\Crm\Models;

use App\Modules\Accounts\Models\Advance;
use App\Modules\Accounts\Models\MoneyReceipt;
use App\Modules\Accounts\Models\ServiceCharge;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function seatBooking()
    {
        return $this->hasMany(SeatBooking::class);
    }

    public function seatBooked()
    {
        return $this->hasOne(SeatBooking::class)->latest();
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
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
