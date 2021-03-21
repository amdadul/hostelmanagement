<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\AssetTypeDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\AssetsType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetsTypeController extends Controller
{
    public function index(AssetTypeDataTable $dataTable)
    {
        $pageTitle = "List of Asset Types";
        return $dataTable->render('Accounts::asset_types.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Asset Type";
        $rootTypes = AssetsType::all();
        return view('Accounts::asset_types.create',compact('pageTitle','rootTypes'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'root_id'=>'required',
            'name'=>'required',
        ]);


        $data = new AssetsType();
        $data->root_id = $request->root_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Asset Type.");
        }
        return $this->responseJson(false, 200, "Asset Type Created Successfully.");

    }

    public function edit($id)
    {
        $pageTitle = "Edit a Asset Type";
        $rootTypes = AssetsType::all();
        $data = AssetsType::find($id);
        return view('Accounts::asset_types.edit',compact('pageTitle','rootTypes','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'root_id'=>'required',
            'name'=>'required',
        ]);


        $data = AssetsType::find($id);
        $data->root_id = $request->root_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Asset Type.");
        }
        return $this->responseJson(false, 200, "Asset Type Updated Successfully.");

    }

    public function delete($id)
    {
        $data = AssetsType::find($id);
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
