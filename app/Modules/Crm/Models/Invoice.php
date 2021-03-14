<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function invoiceDetails()
    {
        $this->hasMany(InvoiceDetails::class);
    }


}
