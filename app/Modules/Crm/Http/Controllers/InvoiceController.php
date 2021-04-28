<?php

namespace App\Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Config\Models\lookup;
use App\Modules\Crm\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class InvoiceController extends Controller
{
    public function getDueInvoice(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('customer_id')) {
            $customer_id = trim($request->customer_id);
            $data = new Invoice();
            $data = $data->where('customer_id', '=', $customer_id);
            $data = $data->where('full_paid', '=', Invoice::DUE);
            $data = $data->orderby('id', 'asc');
            $data = $data->get();
        }

        $payment_type = Lookup::getLookupByType(lookup::PAYMENT_METHOD);
        $cash_credit = Lookup::getLookupByType(lookup::CASH_CREDIT);
        $bank = Lookup::getLookupByType(lookup::BANK);
        $returnHTML = view('Accounts::money_receipt.due-invoice-list', compact('data', 'cash_credit', 'bank', 'payment_type'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
