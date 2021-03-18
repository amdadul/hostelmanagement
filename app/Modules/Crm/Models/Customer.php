<?php

namespace App\Modules\Crm\Models;

use App\Modules\Accounts\Models\Advance;
use App\Modules\Accounts\Models\MoneyReceipt;
use App\Modules\Accounts\Models\ServiceCharge;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function seatBooking()
    {
        $this->hasMany(SeatBooking::class);
    }

    public function seatBooked()
    {
        $this->hasOne(SeatBooking::class)->latest();
    }

    public function invoice()
    {
        $this->hasMany(Invoice::class);
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
