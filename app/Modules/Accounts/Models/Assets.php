<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $guarded = [];

    public function assetsType()
    {
        $this->belongsTo(AssetsType::class);
    }

}
