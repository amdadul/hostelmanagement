<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\CustomersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(CustomersDataTable $dataTable)
    {
        $pageTitle = "List of Customers";
        return $dataTable->render('Crm::customers.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Customer";
        $buildings = Building::all();
        return view('Crm::customers.create',compact('pageTitle','buildings'));
    }
}
