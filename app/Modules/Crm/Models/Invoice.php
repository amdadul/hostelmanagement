<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    const MONTHLY_CHARGE = 1;
    const ADVANCE = 2;
    const SERVICE_CHARGE = 3;

    const DUE = 0;
    const PAID = 1;

    public function maxSlNo(){
        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function invoiceDetails()
    {
        $this->hasMany(InvoiceDetails::class);
    }


}
