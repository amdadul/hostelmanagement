<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{
    protected $guarded = [];

    public function expenses()
    {
        $this->belongsTo(Expense::class);
    }

    public function expenseType()
    {
        $this->belongsTo(ExpenseType::class);
    }
}
