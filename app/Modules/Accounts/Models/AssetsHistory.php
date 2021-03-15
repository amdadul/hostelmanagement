<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class AssetsHistory extends Model
{
    protected $guarded = [];

    public function assets()
    {
        $this->belongsTo(Assets::class);
    }

}
