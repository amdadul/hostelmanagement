<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $guarded = [];

    const AVAILABLE = 1;
    const BOOKED = 0;

    public static function roomBooked($room_id)
    {
        $data = Seat::where('room_id','=',$room_id)->get();
        $totalSeat = count($data);
        $totalBooked = 0;
        foreach ($data as $row)
        {
            if($row->status==0)
            {
                $totalBooked++;
            }
        }
        return ($totalSeat==$totalBooked)?true:false;
    }

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
