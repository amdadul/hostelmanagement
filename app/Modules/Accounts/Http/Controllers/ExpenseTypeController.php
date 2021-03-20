<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\ExpenseTypeDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\ExpenseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index(ExpenseTypeDataTable $dataTable)
    {
        $pageTitle = "List of Expense Types";
        return $dataTable->render('Accounts::expense_type.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Expense Type";
        $rootTypes = ExpenseType::all();
        return view('Accounts::expense_type.create',compact('pageTitle','rootTypes'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'root_id'=>'required',
            'name'=>'required',
        ]);


        $data = new ExpenseType();
        $data->root_id = $request->root_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Expense Type.");
        }
        return $this->responseJson(false, 200, "Expense Type Created Successfully.");

    }

    public function edit($id)
    {
        $pageTitle = "Edit a Expense Type";
        $rootTypes = ExpenseType::all();
        $data = ExpenseType::find($id);
        return view('Accounts::expense_type.edit',compact('pageTitle','rootTypes','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'root_id'=>'required',
            'name'=>'required',
        ]);


        $data = ExpenseType::find($id);
        $data->root_id = $request->root_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Expense Type.");
        }
        return $this->responseJson(false, 200, "Expense Type Updated Successfully.");

    }

    public function delete($id)
    {
        $data = ExpenseType::find($id);
        if($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else{
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }
}
