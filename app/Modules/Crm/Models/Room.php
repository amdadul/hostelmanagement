<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function flat()
    {
        $this->belongsTo(Flat::class);
    }

    public function seat()
    {
        $this->hasMany(Seat::class);
    }
}
