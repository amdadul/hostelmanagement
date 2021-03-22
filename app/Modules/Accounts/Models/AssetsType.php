<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class AssetsType extends Model
{
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(AssetsType::class,'root_id');
    }

    public function assets()
    {
        return $this->hasMany(Assets::class);
    }

    public function parent()
    {
        return $this->belongsTo(AssetsType::class,'root_id');
    }
}
