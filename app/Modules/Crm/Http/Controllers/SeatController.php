<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SeatsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Flat;
use App\Modules\Crm\Models\Floor;
use App\Modules\Crm\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(SeatsDataTable $dataTable)
    {
        $pageTitle = "List of Seats";
        return $dataTable->render('Crm::seats.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Seat";
        $buildings = Building::all();
        return view('Crm::seats.create',compact('pageTitle','buildings'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'flat_name'=>'required',
            'room_name'=>'required',
        ]);

        $data = new Room();
        $data->flat_id = $request->flat_name;
        $data->name = $request->room_name;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Room.");
        }
        return $this->responseJson(false, 200, "Room Created Successfully.");
    }

    public function edit($id)
    {
        $pageTitle = "Edit a Room";
        $buildings = Building::all();
        $floors = Floor::all();
        $flats = Flat::all();
        $data = Room::find($id);
        return view('Crm::seats.edit',compact('pageTitle','buildings','floors','flats','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'flat_name'=>'required',
            'room_name'=>'required',
        ]);

        $data = Room::find($id);
        $data->flat_id = $request->flat_name;
        $data->name = $request->room_name;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Room.");
        }
        return $this->responseJson(false, 200, "Room Updated Successfully.");
    }

    public function delete($id)
    {
        $data = Room::find($id);
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
