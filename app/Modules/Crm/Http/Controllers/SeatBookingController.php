<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SeatBookingDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Advance;
use App\Modules\Accounts\Models\ServiceCharge;
use App\Modules\Config\Models\lookup;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Room;
use App\Modules\Crm\Models\Seat;
use App\Modules\Crm\Models\SeatBooking;
use App\Modules\Crm\Models\SeatBookingDetails;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SeatBookingController extends Controller
{
    public function index(SeatBookingDataTable $dataTable)
    {
        $pageTitle = "List of Seat Bookings";
        return $dataTable->render('Crm::booking.index',compact('pageTitle'));
    }

    public function create()
    {
        $pageTitle = "New Seat booking";
        $buildings = Building::all();
        $payment_type = lookup::getLookupByType(lookup::PAYMENT_METHOD);
        $bank = lookup::getLookupByType(lookup::BANK);
        return view('Crm::booking.create',compact('pageTitle','buildings','payment_type','bank'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'start_date' => 'required|date',
            'customer_id' => 'required|integer',
            'product' => 'required|array',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $booking = new SeatBooking();
            $maxSlNo = $booking->maxSlNo();
            $year = Carbon::now()->year;
            $invNo = "CH-SB-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);


            $booking->max_sl_no = $maxSlNo;
            $booking->voucher_no = $invNo;
            $booking->booking_date = $date = date('Y-m-d');
            $booking->start_date = $params['start_date'];
            $booking->end_date = $params['end_date'];
            $booking->customer_id = $customer_id = $params['customer_id'];
            $booking->grand_total = $grand_total = $params['grand_total'];
            $booking->created_by = $created_by = auth()->user()->id;
            $booking->updated_by = $updated_by = auth()->user()->id;
            if ($booking->save()) {
                $booking_id = $booking->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['product']['temp_seat_id'] as $seat_id) {
                    $seat_price = $params['product']['temp_booking_price'][$i];

                        $bookingDetails = new SeatBookingDetails();
                        $bookingDetails->booking_id = $booking_id;
                        $bookingDetails->seat_id = $seat_id;
                        $bookingDetails->price = $seat_price;
                        $i++;
                        if($bookingDetails->save()) {
                            $seat = Seat::find($seat_id);
                            $seat->status = Seat::BOOKED;
                            if($seat->save())
                            {
                                if(Seat::roomBooked($seat->room_id))
                                {
                                    $room = Room::find($seat->room_id);
                                    $room->status = Room::BOOKED;
                                    $room->save();
                                }
                            }
                            else
                            {
                                $isAnyItemIsMissing = true;
                            }
                        }
                        else {
                            $isAnyItemIsMissing = true;
                        }
                    }

                if($params['service_charge']>0)
                {
                    $scharge = new ServiceCharge();
                    $maxSlNo = $scharge->maxSlNo();
                    $year = Carbon::now()->year;
                    $invNo = "CH-SC-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

                    $scharge->max_sl_no = $maxSlNo;
                    $scharge->voucher_no = $invNo;
                    $scharge->booking_id = $booking_id;
                    $scharge->customer_id = $customer_id;
                    $scharge->collection_type = $params['payment_method'];
                    $scharge->bank_id = $params['bank_id'];
                    $scharge->cheque_no = $params['cheque_no'];
                    $scharge->cheque_date = $params['cheque_date'];
                    $scharge->date = $date;
                    $scharge->amount = $params['service_charge'];
                    $scharge->created_by = $created_by;
                    $scharge->updated_by = $updated_by;
                    if($scharge->save()) {
                    }
                    else {
                        $isAnyItemIsMissing = true;
                    }
                }

                if($params['advance']>0)
                {
                    $advance = new Advance();
                    $maxSlNo = $advance->maxSlNo();
                    $year = Carbon::now()->year;
                    $invNo = "CH-AP-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

                    $advance->max_sl_no = $maxSlNo;
                    $advance->voucher_no = $invNo;
                    $advance->booking_id = $booking_id;
                    $advance->customer_id = $customer_id;
                    $advance->collection_type = $params['payment_method'];
                    $advance->bank_id = $params['bank_id'];
                    $advance->cheque_no = $params['cheque_no'];
                    $advance->cheque_date = $params['cheque_date'];
                    $advance->date = $date;
                    $advance->amount = $params['advance'];
                    $advance->created_by = $created_by;
                    $advance->updated_by = $updated_by;
                    if($advance->save()) {
                    }
                    else {
                        $isAnyItemIsMissing = true;
                    }
                }

                if ($isAnyItemIsMissing == false) {
                    DB::commit();
                    return $this->responseRedirectToWithParameters('crm.seat-booking.voucher', ['id' => $booking_id], 'Seat booked successfully', 'success', false, false);
                } else {
                    DB::rollback();
                    return $this->responseRedirectBack('Error occurred while booking a seat.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Error occurred while booking a seat.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    function voucher($id)
    {
        $pageTitle = 'Seat Booking Voucher';
        $booking = SeatBooking::find($id);
        return view('Crm::booking.voucher',compact('pageTitle','booking'));
    }

}
