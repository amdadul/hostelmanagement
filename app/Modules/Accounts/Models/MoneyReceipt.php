<?php

namespace App\Modules\Accounts\Models;

use App\Modules\Crm\Models\Customer;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\Seat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MoneyReceipt extends Model
{
    protected $guarded = [];

    const MONTHLY_CHARGE = 1;
    const ADVANCE = 2;
    const SERVICE_CHARGE = 3;

    public function maxSlNo(){
        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalMrAmountOfInvoice($invoice_id)
    {
        $data = DB::table('money_receipts')
            ->select(DB::raw('sum(amount) as amount'), DB::raw('sum(discount) as discount'))
            ->where('invoice_id', '=', $invoice_id)->first();
        return $data ? $data->amount + $data->discount : 0;
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
