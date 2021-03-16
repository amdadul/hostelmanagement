<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\FlatsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Flat;
use App\Modules\Crm\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlatController extends Controller
{
    public function index(FlatsDataTable $dataTable)
    {
        $pageTitle = "List of Flats";
        return $dataTable->render('Crm::flats.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Flat";
        $buildings = Building::all();
        return view('Crm::flats.create',compact('pageTitle','buildings'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'floor_name'=>'required',
            'flat_name'=>'required',
        ]);

        $data = new Flat();
        $data->floor_id = $request->floor_name;
        $data->name = $request->flat_name;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Flat.");
        }
        return $this->responseJson(false, 200, "Flat Created Successfully.");
    }

    public function edit($id)
    {
        $pageTitle = "Edit a Flat";
        $buildings = Building::all();
        $floors = Floor::all();
        $data = Flat::find($id);
        return view('Crm::flats.edit',compact('pageTitle','buildings','floors','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'floor_name'=>'required',
            'flat_name'=>'required',
        ]);

        $data = Flat::find($id);
        $data->floor_id = $request->floor_name;
        $data->name = $request->flat_name;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Flat.");
        }
        return $this->responseJson(false, 200, "Flat Updated Successfully.");
    }

    public function delete($id)
    {
        $data = Flat::find($id);
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
