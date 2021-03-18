<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SeatPricesDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Seat;
use App\Modules\Crm\Models\SeatPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeatPriceController extends Controller
{
    public function index(SeatPricesDataTable $dataTable)
    {
        $pageTitle = "List of Seat Prices";
        return $dataTable->render('Crm::seat-prices.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create a New Seat Prices";
        $buildings = Building::all();
        return view('Crm::seat-prices.create',compact('pageTitle','buildings'));
    }

    public function store(Request $request):?jsonResponse
    {
        $request->validate([
            'seat_name'=>'required',
            'seat_price'=>'required',
        ]);

        SeatPrice::where('seat_id','=',$request->seat_name)->update(['status'=>0,'updated_by'=>auth()->user()->id]);

        $seatPrice = new SeatPrice();
        $seatPrice->seat_id = $request->seat_name;
        $seatPrice->price = $request->seat_price;
        $seatPrice->date = date('Y-m-d');
        $seatPrice->created_by = auth()->user()->id;
        $seatPrice->updated_by = auth()->user()->id;

        if (!$seatPrice->save()) {
            return $this->responseJson(true, 200, "Error occur when Creating Seat Price.");
        }
        return $this->responseJson(false, 200, "Seat Price Created Successfully.");

    }

    public function deactive(Request $request)
    {
        $data = SeatPrice::find($request->id);
        $data->status = 0;
        $data->updated_by = auth()->user()->id;

        if($data->save()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deactivated successfully!',
            ]);
        } else{
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }

    public function delete($id)
    {
        $data = SeatPrice::find($id);
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
