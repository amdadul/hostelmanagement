<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\MoneyReceiptDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\MoneyReceipt;
use App\Modules\Config\Models\lookup;
use App\Modules\Crm\Models\Invoice;
use Illuminate\Http\Request;

class MoneyReceiptController extends Controller
{
    public function index(MoneyReceiptDataTable $dataTable)
    {
        $pageTitle = "List of Money Receipt";
        return $dataTable->render('Accounts::money_receipt.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create new money receipt";
        $payment_type = lookup::getLookupByType(lookup::PAYMENT_METHOD);
        $bank = lookup::getLookupByType(lookup::BANK);
        return view('Accounts::money_receipt.create',compact('pageTitle','payment_type','bank'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|integer',
            'mr' => 'required|array',
            'grand_total' => 'required'
        ]);
        $params = $request->except('_token');

        $date = date("Y-m-d");
        $i = 0;
        $mr = new MoneyReceipt();
        $maxSlNo = $mr->maxSlNo();
        $year = date('y');
        $invNo = "CH-MR-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);
        foreach ($params['mr']['invoice_id'] as $invoice) {

            $row_due = $params['mr']['row_due'][$i];
            $payment_amount = $params['mr']['payment_amount'][$i];
            $discount_amount = $params['mr']['discount_amount'][$i];


            if ($payment_amount > 0 || $discount_amount > 0) {
                $model = new MoneyReceipt();
                $model->max_sl_no = $maxSlNo;
                $model->voucher_no = $invNo;
                $model->invoice_id = $invoice;
                $model->receipt_type = Invoice::receiptType($invoice);
                $model->collection_type = $params['payment_method'];
                $model->amount = $payment_amount > 0 ? $payment_amount : 0;
                $model->discount = $discount_amount > 0 ? $discount_amount : 0;
                $model->date = $date;
                $model->bank_id = $params['bank_id'];
                $model->cheque_no = $params['cheque_no'];
                $model->cheque_date = $params['cheque_date'];
                $model->created_by = $created_by = auth()->user()->id;
                $model->customer_id = $params['customer_id'];
                $model->remarks = $params['remarks'];
                $model->status = 1;
                $model->save();
                if ($row_due <= 0) {
                    $invoiceModel = Invoice::findOrFail($invoice);
                    if ($invoiceModel) {
                        $invoiceModel->full_paid = Invoice::PAID;
                        $invoiceModel->save();
                    }
                }
            }
            $i++;
        }
        $data = new MoneyReceipt();
        $data = $data->where('voucher_no', '=', $invNo);
        $data = $data->get();
        if ($data) {
            $returnHTML = view('Accounts::money_receipt.voucher', compact('data'))->render();
            return $this->responseJson(false, 200, "MR Created Successfully.", $returnHTML);
        } else {
            return $this->responseJson(true, 200, "Voucher not found!");
        }
    }

    public function voucher($voucher_no)
    {
            $data = new MoneyReceipt();
            $data = $data->where('voucher_no', '=', $voucher_no);
            $data = $data->get();
            $pageTitle = "Money Receipt Voucher";
            return view('Accounts::money_receipt.voucher',compact('pageTitle','data'));
    }
}
