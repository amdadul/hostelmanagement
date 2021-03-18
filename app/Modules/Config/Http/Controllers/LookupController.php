<?php

namespace App\Modules\Config\Http\Controllers;

use App\DataTables\LookupsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Config\Models\lookup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LookupController extends Controller
{
    public function index(LookupsDataTable $dataTable)
    {
        $pageTitle = "List of Lookups";
        return $dataTable->render('Config::lookups.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Lookups";
        $types = DB::table('lookups')->select('type')->groupBy('type')->get();
        return view('Config::lookups.create',compact('pageTitle','types'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'type'=>'required',
            'lookup_name'=>'required',
        ]);

        $maxCode = lookup::getMaxId($request->type);
        $data = new lookup();
        $data->name = $request->lookup_name;
        $data->type = $request->type;
        $data->code = $maxCode;

        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating lookup.");
        }
        return $this->responseJson(false, 200, "Lookup Created Successfully.");

    }

    public function edit($id)
    {
        $pageTitle = "Create a New Lookups";
        $types = DB::table('lookups')->select('type')->groupBy('type')->get();
        $data = lookup::find($id);
        return view('Config::lookups.edit',compact('pageTitle','types','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'type'=>'required',
            'lookup_name'=>'required',
        ]);

        $data = lookup::find($id);
        if($data->type==$request->type)
        {
            $data->name = $request->lookup_name;
        }
        else
        {
            $maxCode = lookup::getMaxId($request->type);
            $data->name = $request->lookup_name;
            $data->type = $request->type;
            $data->code = $maxCode;
        }


        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when updating lookup.");
        }
        return $this->responseJson(false, 200, "Lookup updated Successfully.");

    }

    public function delete($id)
    {
        $data = lookup::find($id);
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
