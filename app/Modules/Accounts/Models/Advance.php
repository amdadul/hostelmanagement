<?php

namespace App\Modules\Accounts\Models;

use App\Modules\Crm\Models\Customer;
use App\Modules\Crm\Models\Seat;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $guarded = [];

    public function maxSlNo(){
        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function seat()
    {
        $this->belongsTo(Seat::class);
    }

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function moneyReceipt()
    {
        $this->belongsTo(MoneyReceipt::class);
    }
}
