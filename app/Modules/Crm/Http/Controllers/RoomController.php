<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\RoomsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Flat;
use App\Modules\Crm\Models\Floor;
use App\Modules\Crm\Models\Room;
use App\Modules\Crm\Models\Seat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(RoomsDataTable $dataTable)
    {
        $pageTitle = "List of Rooms";
        return $dataTable->render('Crm::rooms.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Room";
        $buildings = Building::all();
        return view('Crm::rooms.create',compact('pageTitle','buildings'));
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
        return view('Crm::rooms.edit',compact('pageTitle','buildings','floors','flats','data'));
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

    public function getRoomByFlat(Request $request):?jsonResponse
    {
        $data = Room::where('flat_id','=',$request->flat_id)->get();
        return response()->json($data);
    }

    public function getAvailableRoomByFlat(Request $request):?jsonResponse
    {
        $data = Room::where('flat_id','=',$request->flat_id)->where('status','=',Room::AVAILABLE)->get();
        return response()->json($data);
    }

    public function getSeatQtyByRoom(Request $request):?jsonResponse
    {
        $search = trim($request->search);

        $data = DB::table('rooms as r')
            ->select(DB::raw('r.id, r.name as room, flt.name as flat, flr.name as floor'))
            ->leftJoin('flats as flt', 'r.flat_id', '=', 'flt.id')
            ->leftJoin('floors as flr', 'flt.floor_id', '=', 'flr.id')
            ->leftJoin('buildings as b', 'flr.building_id', '=', 'b.id')
            ->where(DB::raw("b.id"), "=", $request->building_id)
            ->where(DB::raw("r.name"), "like", '%'.$search.'%')
            ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $dt) {
                $seat = Seat::where('room_id','=',$dt->id)->where('status','=',Seat::AVAILABLE)->get();
                $seatAvail = count($seat);
                $response[] = array("value" => $dt->id, "label" => $dt->room, 'name' => $dt->room, 'flat' => $dt->flat, 'floor' => $dt->floor, 'seat' => $seatAvail, 'seatqty' =>0);
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', 'name' => '',  'flat' => '', 'floor' => '', 'seat'=>0, 'seatqty' =>'No Seat Available');
        }
        return response()->json($response);
    }
}
