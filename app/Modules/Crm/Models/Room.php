<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    const AVAILABLE = 1;
    const BOOKED = 0;

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function seat()
    {
        return $this->hasMany(Seat::class);
    }
}
