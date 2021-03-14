<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $guarded = [];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function flat()
    {
        return $this->hasMany(Flat::class);
    }
}
