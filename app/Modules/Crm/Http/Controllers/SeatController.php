<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SeatsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Flat;
use App\Modules\Crm\Models\Floor;
use App\Modules\Crm\Models\Room;
use App\Modules\Crm\Models\Seat;
use App\Modules\Crm\Models\SeatPrice;
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
            'room_name'=>'required',
            'seat_name'=>'required',
            'seat_price'=>'required',
        ]);

        $data = new Seat();
        $data->room_id = $request->room_name;
        $data->name = $request->seat_name;
        $data->code = $request->seat_code;
        $data->created_by = auth()->user()->id;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Seat.");
        }
        $seatPrice = new SeatPrice();
        $seatPrice->seat_id = $data->id;
        $seatPrice->price = $request->seat_price;
        $seatPrice->date = date('Y-m-d');
        $seatPrice->created_by = auth()->user()->id;
        $seatPrice->updated_by = auth()->user()->id;
        if($seatPrice->save())
        {
            return $this->responseJson(false, 200, "Seat Created Successfully.");
        }
        else
        {
            return $this->responseJson(true, 200, "Error occur when Creating Seat Price.");
        }

    }

    public function edit($id)
    {
        $pageTitle = "Edit a Seat";
        $buildings = Building::all();
        $floors = Floor::all();
        $flats = Flat::all();
        $rooms = Room::all();
        $data = Seat::find($id);
        return view('Crm::seats.edit',compact('pageTitle','buildings','floors','flats','rooms','data'));
    }

    public function update(Request $request,$id):?jsonResponse
    {
        $request->validate([
            'room_name'=>'required',
            'seat_name'=>'required',
            'seat_price'=>'required',
        ]);

        $data = Seat::find($id);
        $data->room_id = $request->room_name;
        $data->name = $request->seat_name;
        $data->code = $request->seat_code;
        $data->updated_by = auth()->user()->id;
        if (!$data->save()) {
            return $this->responseJson(true, 200, "Error occur when Updating Seat.");
        }

        SeatPrice::where('seat_id','=',$data->id)->update(['status'=>0]);

        $seatPrice = new SeatPrice();
        $seatPrice->seat_id = $data->id;
        $seatPrice->price = $request->seat_price;
        $seatPrice->date = date('Y-m-d');
        $seatPrice->updated_by = auth()->user()->id;
        if($seatPrice->save())
        {
            return $this->responseJson(false, 200, "Seat Updated Successfully.");
        }
        else
        {
            return $this->responseJson(true, 200, "Error occur when Updating Seat Price.");
        }
    }

    public function delete($id)
    {
        $data = Seat::find($id);
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

    public function getSeatByRoom(Request $request):?jsonResponse
    {
        $data = Seat::where('room_id','=',$request->room_id)->get();
        return response()->json($data);
    }

    public function getAvaiableSeatByRoom(Request $request):?jsonResponse
    {
        $data = Seat::where('room_id','=',$request->room_id)->where('status','=',Seat::AVAILABLE)->get();
        return response()->json($data);
    }
}
