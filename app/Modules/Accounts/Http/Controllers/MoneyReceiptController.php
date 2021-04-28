<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\MoneyReceiptDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Config\Models\lookup;
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

    }
}
