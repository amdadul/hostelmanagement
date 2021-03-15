<?php

namespace App\Modules\Accounts\Models;

use App\Modules\Crm\Models\Customer;
use App\Modules\Crm\Models\Seat;
use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
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
