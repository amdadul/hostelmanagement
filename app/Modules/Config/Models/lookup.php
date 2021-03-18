<?php

namespace App\Modules\Config\Models;

use Illuminate\Database\Eloquent\Model;

class lookup extends Model
{
    protected $guarded = [];

    public static function getMaxId($type)
    {
        $data = lookup::where('type','=',$type)->max('code');
        return $data?$data+1:1;
    }
}
