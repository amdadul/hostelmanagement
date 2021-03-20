<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(ExpenseType::class,'root_id');
    }

    public function parent()
    {
        return $this->belongsTo(ExpenseType::class,'root_id');
    }
}
