<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SeatBookingDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Advance;
use App\Modules\Accounts\Models\ServiceCharge;
use App\Modules\Config\Models\lookup;
use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Customer;
use App\Modules\Crm\Models\Invoice;
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

    public function booking()
    {
        $pageTitle = "Quick Seat booking";
        $buildings = Building::all();
        $genders = lookup::getLookupByType(lookup::GENDER);
        $relations = lookup::getLookupByType(lookup::RELATION);
        $religions = lookup::getLookupByType(lookup::RELIGION);
        $marital_statuses = lookup::getLookupByType(lookup::MARITAL_STATUS);
        $professions = lookup::getLookupByType(lookup::PROFESSION);
        $payment_type = lookup::getLookupByType(lookup::PAYMENT_METHOD);
        $bank = lookup::getLookupByType(lookup::BANK);
        return view('Crm::booking.quick-booking',compact('pageTitle','buildings','payment_type','bank','genders','relations','religions','marital_statuses','professions'));
    }


    public function bookingStore(Request $request)
    {

        $this->validate($request, [
            'start_date' => 'required|date',
            'customer_name' => 'required',
            'seat_qty' => 'required|integer',
            'building_name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'nid'=>'required',
            'guardian_name'=>'required',
            'gphone'=>'required',
            'gender'=>'required',
            'religion'=>'required',
            'marital_status'=>'required',
            'profession'=>'required',
            'relation'=>'required',
            'monthly_charge'=>'required',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();

            $data = new Customer();
            $data->building_id = $request->building_name;
            $data->name = $request->customer_name;
            $data->email = $request->email;
            $data->phone_no = $request->phone;
            $data->address = $request->address;
            $data->nid = $request->nid;

            $data->fathers_name = $request->fathers_name;
            $data->fathers_phone = $request->fathers_phone;
            $data->fathers_profession = $request->fathers_profession;
            $data->mothers_name = $request->mothers_name;
            $data->mothers_phone = $request->mothers_phone;
            $data->reason_to_stay = $request->reason_to_stay;

            $data->guardian_name = $request->guardian_name;
            $data->guardian_phone_no = $request->gphone;
            $data->relation_with_guardian = $request->relation;
            $data->religion = $request->religion;
            $data->marital_status = $request->marital_status;
            $data->gender = $request->gender;
            $data->profession = $request->profession;
            $data->created_by = $created_by = auth()->user()->id;
            $data->updated_by = $updated_by = auth()->user()->id;
            if ($data->save()) {
                $customer_id = $data->id;

                $booking = new SeatBooking();
                $maxSlNo = $booking->maxSlNo();
                $year = Carbon::now()->year;
                $invNo = "CH-SB-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

                $booking->max_sl_no = $maxSlNo;
                $booking->voucher_no = $invNo;
                $booking->booking_date = $date = date('Y-m-d');
                $booking->start_date = $params['start_date'];
                $booking->end_date = $params['end_date'];
                $booking->customer_id = $customer_id;
                $booking->service_charge = $service_charge = $params['service_charge'];
                $booking->monthly_charge = $monthly_charge = $params['monthly_charge'];
                $booking->room_id = $roomid = $params['room_id'];
                $booking->seat_qty = $seat_qty = $params['seat_qty'];
                $booking->grand_total = $grand_total = $service_charge+$monthly_charge;
                $booking->created_by = $created_by;
                $booking->updated_by = $updated_by;

                if ($booking->save()) {
                    $booking_id = $booking->id;
                    $isAnyItemIsMissing = false;
                    $i =1;
                    for ($i;$i<=$seat_qty;$i++) {
                        $seat = Seat::where('room_id', '=', $roomid)->where('status','=',Seat::AVAILABLE)->first();
                        $seat->status = Seat::BOOKED;
                        if ($seat->save()) {
                            if (Seat::roomBooked($seat->room_id)) {
                                $room = Room::find($seat->room_id);
                                $room->status = Room::BOOKED;
                                $room->save();
                            }
                        } else {
                            $isAnyItemIsMissing = true;
                        }
                    }

                    $invoice = new Invoice();
                    $maxSlNo = $invoice->maxSlNo();
                    $year = Carbon::now()->year;
                    $invoiceNo = "CH-INV-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);
                    $invoice->max_sl_no = $maxSlNo;
                    $invoice->booking_id = $booking_id;
                    $invoice->invoice_no = $invoiceNo;
                    $invoice->customer_id = $customer_id;
                    $invoice->invoice_month = $params['start_date'];
                    $invoice->room_id = $roomid;
                    $invoice->seat_qty = $seat_qty;
                    $invoice->amount = $monthly_charge;
                    $invoice->date = date('Y-m-d');
                    $invoice->invoice_type = Invoice::ADVANCE;
                    if ($invoice->save()) {
                    } else {
                        $isAnyItemIsMissing = true;
                    }

                    if ($params['service_charge'] > 0) {
                        $charge = new Invoice();
                        $maxSlNo = $charge->maxSlNo();
                        $year = Carbon::now()->year;
                        $invoiceNo = "CH-INV-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);
                        $charge->max_sl_no = $maxSlNo;
                        $charge->invoice_no = $invoiceNo;
                        $charge->booking_id = $booking_id;
                        $charge->customer_id = $customer_id;
                        $charge->invoice_month = $params['start_date'];
                        $charge->room_id = $roomid;
                        $charge->seat_qty = $seat_qty;
                        $charge->amount = $service_charge;
                        $charge->date = date('Y-m-d');
                        $charge->invoice_type = Invoice::SERVICE_CHARGE;
                        if ($charge->save()) {
                        } else {
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
                    DB::rollback();
                    return $this->responseRedirectBack('Error occurred while booking a seat.', 'error', true, true);
                }
            }
            else
            {
                return $this->responseRedirectBack('Error occurred while creating Customer.', 'error', true, true);
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
        return view('Crm::booking.booking-voucher',compact('pageTitle','booking'));
    }

}
