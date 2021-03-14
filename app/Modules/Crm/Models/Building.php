<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $guarded = [];

    public function flat()
    {
        return $this->hasMany(Flat::class);
    }
}
