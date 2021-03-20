<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\ExpenseTypeDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\ExpenseType;
use Illuminate\Http\Request;

class AssetsTypeController extends Controller
{
    public function index(ExpenseTypeDataTable $dataTable)
    {
        $pageTitle = "List of Assets Type";
        return $dataTable->render('Accounts::expense_type.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Assets Type";
        $rootType = ExpenseType::all();
        return view('Accounts::expense_type.create',compact('pageTitle','rootType'));
    }
}
