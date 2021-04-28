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
        $this->belongsTo(Seat::class);
    }

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        $this->belongsTo(Invoice::class);
    }
}
