<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\FloorsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index(FloorsDataTable $dataTable)
    {
        $pageTitle = "List of Floors";
        return $dataTable->render('Crm::floor.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Floors";
        $buildings = Building::all();
        return view('Crm::floor.create',compact('pageTitle','buildings'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
            'floor_name'=>'required',
        ]);

        $data = new Floor();
        $data->building_id = $request->building_name;
        $data->name = $request->floor_name;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Floor.");
        }
        return $this->responseJson(false, 200, "Floor Created Successfully.");
    }

    public function edit($id)
    {
        $pageTitle = "Edit a Floor";
        $buildings = Building::all();
        $data = Floor::find($id);
        return view('Crm::floor.edit',compact('pageTitle','buildings','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'building_name'=>'required',
            'floor_name'=>'required',
        ]);

        $data = Floor::find($id);
        $data->building_id = $request->building_name;
        $data->name = $request->floor_name;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Floor.");
        }
        return $this->responseJson(false, 200, "Floor Updated Successfully.");
    }

    public function delete($id)
    {
        $data = Floor::find($id);
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

    public function getFloorByBuilding(Request $request):?jsonResponse
    {
        $data = Floor::where('building_id','=',$request->building_id)->get();
        return response()->json($data);
    }
}
