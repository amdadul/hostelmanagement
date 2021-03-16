<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\BuildingsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(BuildingsDataTable $dataTable)
    {
        $pageTitle = "List of buildings";
        return $dataTable->render('Crm::building.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a new building";
        return view('Crm::building.create',compact('pageTitle'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
        ]);

        $data = new Building();
        $data->name = $request->building_name;
        $data->address = $request->address;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Building.");
        }
        return $this->responseJson(false, 200, "Building Created Successfully.");
    }

    public function edit($id)
    {
        $data = Building::find($id);
        $pageTitle = "Edit a building";
        return view('Crm::building.edit',compact('pageTitle','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
        ]);

        $data = Building::find($id);
        $data->name = $request->building_name;
        $data->address = $request->address;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Building.");
        }
        return $this->responseJson(false, 200, "Building Updated Successfully.");
    }

    public function delete($id)
    {
        $data = Building::find($id);
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
