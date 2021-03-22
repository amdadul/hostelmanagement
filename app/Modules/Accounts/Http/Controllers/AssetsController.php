<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\DataTables\AssetsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Assets;
use App\Modules\Accounts\Models\AssetsType;
use App\Modules\Accounts\Models\ExpenseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function index(AssetsDataTable $dataTable)
    {
        $pageTitle = "List of Assets";
        return $dataTable->render('Accounts::assets.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Asset Type";
        $assetTypes = AssetsType::where('name','<>','root')->get();
        return view('Accounts::assets.create',compact('pageTitle','assetTypes'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'assets_type'=>'required',
            'description'=>'required',
        ]);


        $data = new Assets();
        $data->assets_type = $request->assets_type;
        $data->description = $request->description;
        $data->qty = $request->qty?$request->qty:0;
        $data->depreciation = $request->depreciation;
        $data->life_time = $request->life_time;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Assets.");
        }
        return $this->responseJson(false, 200, "Assets Created Successfully.");

    }

    public function edit($id)
    {
        $pageTitle = "Edit a Assets";
        $assetTypes = AssetsType::where('name','<>','root')->get();
        $data = Assets::find($id);
        return view('Accounts::assets.edit',compact('pageTitle','assetTypes','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'assets_type'=>'required',
            'description'=>'required',
        ]);


        $data = Assets::find($id);
        $data->assets_type = $request->assets_type;
        $data->description = $request->description;
        $data->qty = $request->qty?$request->qty:0;
        $data->depreciation = $request->depreciation;
        $data->life_time = $request->life_time;
        $data->updated_by = auth()->user()->id;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Assets.");
        }
        return $this->responseJson(false, 200, "Assets Updated Successfully.");

    }

    public function delete($id)
    {
        $data = Assets::find($id);
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
