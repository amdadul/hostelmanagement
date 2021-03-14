<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $guarded = [];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }
}
