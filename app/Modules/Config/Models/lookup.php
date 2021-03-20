<?php

namespace App\Modules\Config\Models;

use Illuminate\Database\Eloquent\Model;

class lookup extends Model
{
    protected $guarded = [];

    const GENDER = 'gender';
    const MARITAL_STATUS = 'marital_status';
    const RELIGION = 'religion';
    const CASH_CREDIT = 'cash_credit';
    const PAYMENT_METHOD = 'payment_method';
    const BANK = 'bank';
    const PROFESSION = 'profession';
    const RELATION = 'relation';

    public static function getMaxId($type)
    {
        $data = lookup::where('type','=',$type)->max('code');
        return $data?$data+1:1;
    }

    public static function getLookupByType($type)
    {
        $data = lookup::where('type','=',$type)->get();
        return $data;
    }

    public static function getLookupByCode($type,$code)
    {
        $data = lookup::where('type','=',$type)->where('code','=',$code)->first();
        return $data->name;
    }
}
