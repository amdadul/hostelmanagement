<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function invoice()
    {
        $this->belongsTo(Invoice::class);
    }

    public function seat()
    {
        $this->belongsTo(Seat::class);
    }
}
