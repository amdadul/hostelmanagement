<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class SeatPrice extends Model
{
    protected $guarded = [];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
