<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\CustomersDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Config\Models\lookup;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Customer;
use Illuminate\Http\JsonResponse;
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
        $genders = lookup::getLookupByType(lookup::GENDER);
        $relations = lookup::getLookupByType(lookup::RELATION);
        $religions = lookup::getLookupByType(lookup::RELIGION);
        $marital_statuses = lookup::getLookupByType(lookup::MARITAL_STATUS);
        $professions = lookup::getLookupByType(lookup::PROFESSION);
        return view('Crm::customers.create',compact('pageTitle','buildings','genders','relations','religions','marital_statuses','professions'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
            'customer_name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'nid'=>'required',
            'guardian_name'=>'required',
            'gphone'=>'required',
            'gender'=>'required',
            'religion'=>'required',
            'marital_status'=>'required',
            'profession'=>'required',
            'relation'=>'required',
        ]);


        $data = new Customer();
        $data->building_id = $request->building_name;
        $data->name = $request->customer_name;
        $data->email = $request->email;
        $data->phone_no = $request->phone;
        $data->address = $request->address;
        $data->nid = $request->nid;
        $data->guardian_name = $request->guardian_name;
        $data->guardian_phone_no = $request->gphone;
        $data->relation_with_guardian = $request->relation;
        $data->religion = $request->religion;
        $data->marital_status = $request->marital_status;
        $data->gender = $request->gender;
        $data->profession = $request->profession;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Customer.");
        }
        return $this->responseJson(false, 200, "Customer Created Successfully.");

    }

    public function edit($id)
    {
        $pageTitle = "Edit a Customer";
        $buildings = Building::all();
        $genders = lookup::getLookupByType(lookup::GENDER);
        $relations = lookup::getLookupByType(lookup::RELATION);
        $religions = lookup::getLookupByType(lookup::RELIGION);
        $marital_statuses = lookup::getLookupByType(lookup::MARITAL_STATUS);
        $professions = lookup::getLookupByType(lookup::PROFESSION);
        $data = Customer::find($id);
        return view('Crm::customers.edit',compact('pageTitle','buildings','genders','relations','religions','marital_statuses','professions','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
            'customer_name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'nid'=>'required',
            'guardian_name'=>'required',
            'gphone'=>'required',
            'gender'=>'required',
            'religion'=>'required',
            'marital_status'=>'required',
            'profession'=>'required',
            'relation'=>'required',
        ]);


        $data = Customer::find($id);
        $data->building_id = $request->building_name;
        $data->name = $request->customer_name;
        $data->email = $request->email;
        $data->phone_no = $request->phone;
        $data->address = $request->address;
        $data->nid = $request->nid;
        $data->guardian_name = $request->guardian_name;
        $data->guardian_phone_no = $request->gphone;
        $data->relation_with_guardian = $request->relation;
        $data->religion = $request->religion;
        $data->marital_status = $request->marital_status;
        $data->gender = $request->gender;
        $data->profession = $request->profession;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when updating Customer.");
        }
        return $this->responseJson(false, 200, "Customer updated Successfully.");
    }

    public function delete($id)
    {
        $data = Customer::find($id);
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
