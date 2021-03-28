@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <!-- CSS -->
    <style>

        .table-hover tbody tr:hover, .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgb(221 237 241 / 50%);
        }
        .ui-datepicker {
            z-index: 999 !important;
        }

        .tab-2 {
            display: none;
        }

        .tab-3 {
            display: none;
        }

        .tab-4 {
            display: none;
        }

        .tab-5 {
            display: none;
        }

        .tab-6 {
            display: none;
        }
    </style>
@endpush

@section('content')
    @include('admin.master.flash')

    <div class="alert alert-danger print-error-msg " style="display:none">
        <ul></ul>
    </div>

    <section id="basic-form-layouts">
        <div class="row match-height justify-content-md-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="booking-form" action="{{route('crm.seat-booking.booking-store')}}"
                                  method="post" autocomplete="off">
                                @csrf
                                <div class="form-body">
                                    <div class="tab-1">
                                        <h4 class="form-section" style="color: #0c0c0c;"><i class="ft-user"></i> Booking
                                            & Applicant Info</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date">Stay From</label>
                                                    <input type="text"
                                                           class="form-control @error('start_date') is-invalid @enderror"
                                                           id="start_date" value="{!! date('Y-m-d') !!}"
                                                           name="start_date"
                                                           required>
                                                    @error('start_date')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">Leave Date</label>
                                                    <input type="text"
                                                           class="form-control @error('end_date') is-invalid @enderror"
                                                           id="end_date" value="" name="end_date">
                                                    @error('end_date')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="customer_name">Applicant Name <span
                                                            class="required text-danger">*</span></label>
                                                    <input id="customer_name"
                                                           class="form-control @error('customer_name') is-invalid @enderror"
                                                           placeholder="Applicant Name" name="customer_name"
                                                           value="{{old('customer_name')?old('customer_name'):''}}"
                                                           required/>
                                                    @error('customer_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>


                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email">Applicant Email </label>
                                                    <input id="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           placeholder="Applicant Email" name="email"
                                                           value="{{old('email')?old('email'):''}}"/>
                                                    @error('email')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="phone">Applicant Phone <span
                                                            class="required text-danger">*</span></label>
                                                    <input id="phone"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           placeholder="Applicant Phone" name="phone"
                                                           value="{{old('phone')?old('phone'):''}}" required/>
                                                    @error('phone')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="nid">NID/ Birth Certificate No <span
                                                            class="required text-danger">*</span></label>
                                                    <input id="nid"
                                                           class="form-control @error('nid') is-invalid @enderror"
                                                           placeholder="NID/ Birth Certificate No" name="nid"
                                                           value="{{old('nid')?old('nid'):''}}" required/>
                                                    @error('nid')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="address">Permanent Address <span
                                                            class="required text-danger">*</span></label>
                                                    <textarea id="address"
                                                              class="form-control @error('address') is-invalid @enderror"
                                                              placeholder="Address" name="address"
                                                              required>{{old('address')?old('address'):''}}</textarea>
                                                    @error('address')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="reason_to_stay">Reason To Stay </label>
                                                    <input id="reason_to_stay"
                                                           class="form-control @error('reason_to_stay') is-invalid @enderror"
                                                           placeholder="Reason To Stay" name="reason_to_stay"
                                                           value="{{old('reason_to_stay')?old('reason_to_stay'):''}}"/>
                                                    @error('reason_to_stay')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="form-section"><i class="fa fa-paperclip"></i> Others Information</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('gender') is-invalid @enderror"
                                                        id="gender" name="gender" required>
                                                        <option value="0">Select Gender</option>
                                                        @foreach($genders as $gender)
                                                            <option
                                                                value="{{$gender->code}}" {{ old('gender')==$gender->code?'selected':'' }}>{{$gender->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('gender')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="religion">Religion <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('religion') is-invalid @enderror"
                                                        id="religion" name="religion" required>
                                                        <option value="0">Select Religion</option>
                                                        @foreach($religions as $religion)
                                                            <option
                                                                value="{{$religion->code}}" {{ old('religion')==$religion->code?'selected':'' }}>{{$religion->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('religion')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="marital_status">Marital Status <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('marital_status') is-invalid @enderror"
                                                        id="marital_status" name="marital_status" required>
                                                        <option value="0">Select Marital Status</option>
                                                        @foreach($marital_statuses as $marital_status)
                                                            <option
                                                                value="{{$marital_status->code}}" {{ old('marital_status')==$marital_status->code?'selected':'' }}>{{$marital_status->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('marital_status')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="profession">Profession <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('profession') is-invalid @enderror"
                                                        id="profession" name="profession" required>
                                                        <option value="0">Select Profession</option>
                                                        @foreach($professions as $profession)
                                                            <option
                                                                value="{{$profession->code}}" {{ old('profession')==$profession->code?'selected':'' }}>{{$profession->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('profession')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button class="btn btn-primary btn-tab-1">Next <i
                                                    class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                                        </div>
                                    </div>

                                    <div class="tab-2">

                                        <h4 class="form-section" style="color: #0c0c0c;"><i class="ft-user"></i>
                                            Guardian Information</h4>

                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="fathers_name">Fathers Name</label>
                                                    <input id="fathers_name"
                                                           class="form-control @error('fathers_name') is-invalid @enderror"
                                                           placeholder="Fathers Name" name="fathers_name"
                                                           value="{{old('fathers_name')?old('fathers_name'):''}}"/>
                                                    @error('fathers_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="fathers_phone">Fathers Phone No </label>
                                                    <input id="fathers_phone"
                                                           class="form-control @error('fathers_phone') is-invalid @enderror"
                                                           placeholder="Fathers Phone No" name="fathers_phone"
                                                           value="{{old('fathers_phone')?old('fathers_phone'):''}}"/>
                                                    @error('fathers_phone')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="mothers_name">Mothers Name</label>
                                                    <input id="mothers_name"
                                                           class="form-control @error('mothers_name') is-invalid @enderror"
                                                           placeholder="Mothers Name" name="mothers_name"
                                                           value="{{old('mothers_name')?old('mothers_name'):''}}"/>
                                                    @error('mothers_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="mothers_phone">Mothers Phone No </label>
                                                    <input id="mothers_phone"
                                                           class="form-control @error('mothers_phone') is-invalid @enderror"
                                                           placeholder="Mothers Phone No" name="mothers_phone"
                                                           value="{{old('mothers_phone')?old('mothers_phone'):''}}"/>
                                                    @error('mothers_phone')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="guardian_name">Guardian Name <span
                                                            class="required text-danger">*</span></label>
                                                    <input id="guardian_name"
                                                           class="form-control @error('guardian_name') is-invalid @enderror"
                                                           placeholder="Guardian Name" name="guardian_name"
                                                           value="{{old('guardian_name')?old('guardian_name'):''}}"
                                                           required/>
                                                    @error('guardian_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="gphone">Guardian Phone No <span
                                                            class="required text-danger">*</span></label>
                                                    <input id="gphone"
                                                           class="form-control @error('gphone') is-invalid @enderror"
                                                           placeholder="Guardian Phone No" name="gphone"
                                                           value="{{old('gphone')?old('gphone'):''}}" required/>
                                                    @error('gphone')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="relation">Relation with Guardian <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('relation') is-invalid @enderror"
                                                        id="relation" name="relation" required>
                                                        <option value="0">Select Relation</option>
                                                        @foreach($relations as $relation)
                                                            <option
                                                                value="{{$relation->code}}" {{ old('relation')==$relation->code?'selected':'' }}>{{$relation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('relation')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="fathers_profession">Fathers Profession</label>
                                                    <input id="fathers_profession"
                                                           class="form-control @error('fathers_profession') is-invalid @enderror"
                                                           placeholder="Fathers Profession" name="fathers_profession"
                                                           value="{{old('fathers_profession')?old('fathers_profession'):''}}"/>
                                                    @error('fathers_profession')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <h4 class="form-section"><i class="fa fa-paperclip"></i> Seat Information</h4>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="building_name">Building Name <span
                                                            class="required text-danger">*</span></label>
                                                    <select
                                                        class="select2 form-control @error('building_name') is-invalid @enderror"
                                                        id="building_name" name="building_name" required>
                                                        <option value="0">Select Building Name</option>
                                                        @foreach($buildings as $building)
                                                            <option
                                                                value="{{$building->id}}" {{ old('building_name')==$building->id?'selected':'' }}>{{$building->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('building_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="floor_name">Floor Name </label>
                                                    <input type="text"
                                                           class="form-control @error('floor_name') is-invalid @enderror"
                                                           id="floor_name" name="floor_name"/>
                                                    @error('floor_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="flat_name">Flat Name</label>
                                                    <input type="text"
                                                           class="form-control @error('flat_name') is-invalid @enderror"
                                                           id="flat_name" name="flat_name"/>
                                                    @error('flat_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="room_name">Room Name </label>
                                                    <input type="text"
                                                           class="form-control @error('room_name') is-invalid @enderror"
                                                           id="room_name" name="room_name"/>
                                                    @error('room_name')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                                <input type="hidden" class="room_id" id="room_id" name="room_id"/>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="seat_qty">Seat Qty </label>
                                                    <input type="text"
                                                           class="form-control @error('seat_qty') is-invalid @enderror"
                                                           id="seat_qty" name="seat_qty"/>
                                                    @error('seat_qty')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="available-qty" id="available-qty"/>
                                        <h4 class="form-section"><i class="fa fa-paperclip"></i> Charge Information
                                        </h4>
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="service_charge">Service Charge</label>
                                                    <input type="service_charge"
                                                           class="form-control @error('service_charge') is-invalid @enderror"
                                                           id="service_charge" name="service_charge">
                                                    @error('service_charge')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="monthly_charge">Monthly Charge</label>
                                                    <input type="monthly_charge"
                                                           class="form-control @error('monthly_charge') is-invalid @enderror"
                                                           id="monthly_charge" name="monthly_charge">
                                                    @error('monthly_charge')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal fade  bd-example-modal-lg" id="exampleModalLong" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Quick Booking Form</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row" style="height: 120px;">
                                                                <div class="col-md-4 d-flex justify-content-center text-center" ><div class="d-flex justify-content-center align-items-center" style="border: 1px solid black; height: 120px; width: 120px;">অভিভাবকের ছবি</div></div>
                                                                <div class="col-md-4 ml-auto text-center"><img style="width: 200px; margin-top: -50px;" src="{{asset('app-assets/images/city_logo.png')}}"></div>
                                                                <div class="col-md-4 d-flex justify-content-center text-center" ><div class="d-flex justify-content-center align-items-center" style="border: 1px solid black; height: 120px; width: 120px;">আবেদনকারীর ছবি</div></div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>আবেদনকারীর নামঃ</td> <td><span id="aname"></span></td></tr>
                                                                        <tr><td>পিতার নামঃ </td><td><span id="fname"></span></td></tr>
                                                                        <tr><td>মাতার নামঃ </td><td><span id="mname"></span></td></tr>
                                                                        <tr><td>পিতার পেশাঃ </td><td><span id="fprofession"></span></td></tr>
                                                                        <tr><td>জাতীয় পরিচয়পত্র নংঃ </td><td><span id="anid"></span></td></tr>
                                                                        <tr><td>লিঙ্গঃ</td> <td><span id="agender"></span></td></tr>
                                                                        <tr><td>বৈবাহিক অবস্থাঃ </td><td><span id="amarital"></span></td></tr>
                                                                        <tr><td>অভিভাবকের নামঃ </td><td><span id="gname"></span></td></tr>
                                                                        <tr><td>অভিভাবকের সাথে সম্পর্কঃ </td><td><span id="rwg"></span></td></tr>
                                                                        <tr><td>ঠিকানাঃ </td><td><span id="paddress"></span></td></tr>
                                                                    </table></div>
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>আবেদনকারীর মোবাইল নংঃ </td><td><span id="aphone"></span></td></tr>
                                                                        <tr><td>পিতার মোবাইল নংঃ </td><td><span id="fphone"></span></td></tr>
                                                                        <tr><td>মাতার মোবাইল নংঃ </td><td><span id="mphone"></span></td></tr>
                                                                        <tr><td>থাকার কারণঃ </td><td><span id="reason"></span></td></tr>
                                                                        <tr><td>ইমেইলঃ </td><td><span id="aemail"></span></td></tr>
                                                                        <tr><td>ধর্মঃ </td><td><span id="arel"></span></td></tr>
                                                                        <tr><td>পেশাঃ </td><td><span id="aprof"></span></td></tr>
                                                                        <tr><td>অভিভাবকের মোবাইল নংঃ </td><td><span id="gph"></span></td></tr>
                                                                    </table></div>
                                                            </div>

                                                            <div class="row d-flex justify-content-center text-center" style="border-bottom: 1px solid black">
                                                                <b class="text-center">বরাদ্দকৃত রুমের বিবরণ</b>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>বুকিং এর তারিখঃ</td> <td><span id="bdate"></span></td></tr>
                                                                        <tr><td>বাসার নামঃ</td> <td><span id="build"></span></td></tr>
                                                                        <tr><td>ফ্লাটের নামঃ </td><td><span id="flat"></span></td></tr>
                                                                        <tr><td>সিট সংখ্যাঃ </td><td><span id="seat"></span></td></tr>
                                                                    </table></div>
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>ওঠার তারিখঃ </td><td><span id="edate"></span></td></tr>
                                                                        <tr><td>ফ্লোর নংঃ </td><td><span id="floor"></span></td></tr>
                                                                        <tr><td>রুম নংঃ </td><td><span id="room"></span></td></tr>
                                                                    </table></div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>সার্ভিস চার্জ ঃ </td> <td><span id="service"></span></td></tr>
                                                                    </table></div>
                                                                <div class="col-md-6 ml-auto"><table class="table-striped">
                                                                        <tr><td>মাসিক চার্জ ঃ </td><td><span id="monthly"></span></td></tr>
                                                                    </table></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="saveInvoice">
                                                            <i class="fa fa-check-square-o"></i> Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-refresh-ccw"></i> Reload
                                            </button>
                                            <button class="btn btn-primary btn-tab-2p">
                                                <i class="fa fa-angle-double-left" aria-hidden="true"></i> Previous
                                            </button>
                                            <button type="button" class="btn btn-primary load-model" data-toggle="modal"
                                                    data-target="#exampleModalLong">
                                                Save
                                            </button>

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>

        var cashArray = [1];
        var bankArray = [2, 3, 4, 5];
        var paymentChequeArray = [3, 4];

        $(function () {
            $("#start_date").datepicker({
                // appendText:"(yy-mm-dd)",
                dateFormat: "yy-mm-dd",
                altField: "#datepicker",
                altFormat: "DD, d MM, yy",
                prevText: "click for previous months",
                nextText: "click for next months",
                showOtherMonths: true,
                selectOtherMonths: true,
                maxDate: new Date()
            });
        });
        $(function () {
            $("#end_date").datepicker({
                // appendText:"(yy-mm-dd)",
                dateFormat: "yy-mm-dd",
                altField: "#datepicker",
                altFormat: "DD, d MM, yy",
                prevText: "click for previous months",
                nextText: "click for next months",
                showOtherMonths: true,
                selectOtherMonths: true,
                maxDate: new Date()
            });
        });
        $(function () {
            $("#cheque_date").datepicker({
                // appendText:"(yy-mm-dd)",
                dateFormat: "yy-mm-dd",
                altField: "#datepicker",
                altFormat: "DD, d MM, yy",
                prevText: "click for previous months",
                nextText: "click for next months",
                showOtherMonths: true,
                selectOtherMonths: true,
                // maxDate: new Date()
            });
        });

        $(".btn-tab-1").click(function () {
            $(".tab-1").hide();
            $(".tab-2").show();
        });

        $(".btn-tab-2").click(function () {
            $(".tab-2").hide();
            $(".tab-3").show();
        });

        $(".btn-tab-2p").click(function () {
            $(".tab-2").hide();
            $(".tab-1").show();
        });

        $(".btn-tab-3").click(function () {
            $(".tab-3").hide();
            $(".tab-4").show();
        });

        $(".btn-tab-3p").click(function () {
            $(".tab-3").hide();
            $(".tab-2").show();
        });

        $(".btn-tab-4p").click(function () {
            $(".tab-4").hide();
            $(".tab-3").show();
        });

        $(".load-model").click(function () {
            var applicant_name = $("#customer_name").val();
            $("#aname").text(applicant_name);
            var start_date = $("#start_date").val();
            $("#bdate").text(start_date);
            var end_date = $("#end_date").val();
            $("#edate").text(end_date);
            var applicant_phone = $("#phone").val();
            $("#aphone").text(applicant_phone);
            var email = $("#email").val();
            $("#aemail").text(email);
            var nid = $("#nid").val();
            $("#anid").text(nid);
            var address = $("#address").val();
            $("#paddress").text(address);
            var fname = $("#fathers_name").val();
            $("#fname").text(fname);
            var fphone = $("#fathers_phone").val();
            $("#fphone").text(fphone);
            var fprof = $("#fathers_profession").val();
            $("#fprofession").text(fprof);
            var mname = $("#mothers_name").val();
            $("#mname").text(mname);
            var mphone = $("#mothers_phone").val();
            $("#mphone").text(mphone);
            var rts = $("#reason_to_stay").val();
            $("#reason").text(rts);
            var gname = $("#guardian_name").val();
            $("#gname").text(gname);
            var gphone = $("#gphone").val();
            $("#gph").text(gphone);
            var rwg = $("#relation :selected").text();
            $("#rwg").text(rwg);
            var gender = $("#gender :selected").text();
            $("#agender").text(gender);
            var mstatus = $("#marital_status :selected").text();
            $("#amarital").text(mstatus);
            var relig = $("#religion :selected").text();
            $("#arel").text(relig);
            var prof = $("#profession :selected").text();
            $("#aprof").text(prof);
            var bldn = $("#building_name :selected").text();
            $("#build").text(bldn);
            var floor = $("#floor_name").val();
            $("#floor").text(floor);
            var flat = $("#flat_name").val();
            $("#flat").text(flat);
            var room = $("#room_name").val();
            $("#room").text(room);
            var seat = $("#seat_qty").val();
            $("#seat").text(seat);
            var service = $("#service_charge").val();
            $("#service").text(service);
            var charge = $("#monthly_charge").val();
            $("#monthly").text(charge);
        });

        $("#payment_method").change(function () {
            var val = parseInt(this.value);
            if (isValidCode(val, cashArray)) {
                $(".bank_other_payment").hide();
                $(".amount").show();
            } else if (isValidCode(val, bankArray)) {
                $(".bank_other_payment").show();
                $(".amount").show();
            } else {
                $(".bank_other_payment").hide();
            }
        });


        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        function calculateTotal() {
            var service_charge = nanCheck($("#service_charge").val()) ? nanCheck($("#service_charge").val()) : 0;
            var advance = nanCheck($("#advance").val()) ? nanCheck($("#advance").val()) : 0;
            var total = parseFloat(service_charge) + parseFloat(advance);
            $("#total").val(parseFloat(total));
        }

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#building_name').on('change', e => {
            $('#floor_name').empty();
            var building_name = $.trim($('#building_name').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.floors.get-floor') }}",
                type: 'post',
                data: {'building_id': building_name},
                success: data => {
                    $('#floor_name').append(`<option value="0">Select Floor Name</option>`)
                    data.forEach(floor =>
                        $('#floor_name').append(`<option value="${floor.id}">${floor.name}</option>`)
                    )
                }
            })
        })

        $('#floor_name').on('change', e => {
            $('#flat_name').empty();
            var floor_name = $.trim($('#floor_name').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.flats.get-flat') }}",
                type: 'post',
                data: {'floor_id': floor_name},
                success: data => {
                    $('#flat_name').append(`<option value="0">Select Floor Name</option>`)
                    data.forEach(flat =>
                        $('#flat_name').append(`<option value="${flat.id}">${flat.name}</option>`)
                    )
                }
            })
        })

        $('#flat_name').on('change', e => {
            $('#room_name').empty();
            var flat_name = $.trim($('#flat_name').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.rooms.get-avail-room') }}",
                type: 'post',
                data: {'flat_id': flat_name},
                success: data => {
                    $('#room_name').append(`<option value="0">Select Room Name</option>`)
                    data.forEach(room =>
                        $('#room_name').append(`<option value="${room.id}">${room.name}</option>`)
                    )
                }
            })
        })

        $("#room_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var building_id = parseInt($('#building_name').val());

                if (building_id <= 0 || building_id == '') {
                    toastr.error("Please select Building", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                } else {
                    $.ajax({
                        url: "{{ route('crm.rooms.get-seat-count') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            building_id: building_id,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            },
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#room_name').val(ui.item.name);
                    $('#room_id').val(ui.item.value);
                    $('#floor_name').val(ui.item.floor);
                    $('#flat_name').val(ui.item.flat);
                    $('#available-qty').val(ui.item.seat);
                    $('#seat_qty').val(ui.item.seatqty);
                } else {
                    resetProduct();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var inner_html = '<div>' + item.label + ' </div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };


        $('#seat_qty').on('keyup', e => {
            var seatAvail = parseInt($('#available-qty').val());
            var seatGiven = parseInt($('#seat_qty').val());
            if (seatGiven > seatAvail) {
                var message = "Seat Not Available.";
                toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                $('#seat_qty').val(0);
            }
        })


        $(document).on('input keyup drop paste', ".temp_booking_price", function (e) {
            calculateGrandTotal();
        });

        function deleteRows(element) {
            var result = confirm("Are you sure you want to Delete?");
            if (result) {
                var temp_item_id = element.parents('tr').find('.temp_seat_id').html();
                $(element).parents("tr").remove();
                toastr.success(temp_item_id + " removed from grid.", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                var itemCounter = 0;
                $("#table-data-list tbody tr td.sno").each(function (index, element) {
                    itemCounter++;
                    $(element).text(index + 1);
                });
                calculateGrandTotal();
            }
        }

        function calculateGrandTotal() {
            var grand_total = 0;
            $('#table-data-list .temp_booking_price').each(function () {
                grand_total += parseFloat(this.value);
            });
            $("#grand_total_text").html(grand_total);
            $("#grand_total").val(grand_total);
        }

        function resetProduct() {
            $('#floor_name').val('');
            $('#flat_name').val('');
            $('#room_name').val('');
            $('#room_id').val('');
            $('#available-qty').val(0);
        }


        $().ready(function () {
            $('form#booking-form').submit(function () {

                var customer_name = $.trim($('#customer_name').val());
                var seat_qty = $.trim($('#seat_qty').val());
                var date = $('#start_date').val();
                var building_name = $.trim($('#building_name').val());


                if (date === '') {
                    toastr.warning(" Please select start date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (seat_qty === '' || seat_qty <=0) {
                    toastr.warning(" Please enter seat Quantity!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (customer_name === '') {
                    toastr.warning(" Please enter  customer name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (building_name === '') {
                    toastr.warning(" Please select building!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
            });
        });


        $("#customer_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var building_id = $("#building_name").val();
                $.ajax({
                    url: "{{ route('customer.name.autocomplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                        building_id: building_id,
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#customer_name').val(ui.item.name);
                    $('#building_name').val(ui.item.building_id).trigger('change');
                    $('#customer_id').val(ui.item.value);
                    $('#contact_no').val(ui.item.phone_no);
                } else {
                    resetCustomer();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var inner_html = '<div>' + item.label + ' </div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };
        // customer name wise search end

        // customer name wise search start
        $("#contact_no").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                var building_id = $("#building_name").val();
                $.ajax({
                    url: "{{ route('customer.phone.autocomplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                        building_id: building_id,
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                // console.log(event);
                // console.log(ui);
                return false;
            },
            select: function (event, ui) {
                if (ui.item.value != '' || ui.item.value > 0) {
                    $('#customer_name').val(ui.item.name);
                    $('#building_name').val(ui.item.building_id).trigger('change');
                    $('#customer_id').val(ui.item.value);
                    $('#contact_no').val(ui.item.phone_no);
                } else {
                    resetCustomer();
                }
                return false;
            },
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var inner_html = '<div>' + item.label + ' </div>';
            return $("<li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
        };

        function resetCustomer() {
            $('#customer_name').val('');
            $('#customer_id').val('');
            $('#contact_no').val('');
        }

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        function flashMessage(value = 'success') {
            if (value === 'success') {
                $(".print-success-msg").fadeTo(2000, 500).slideUp(500, function () {
                    $(".print-success-msg").slideUp(500);
                });
            } else {
                $(".print-error-msg").fadeTo(2000, 500).slideUp(500, function () {
                    $(".print-error-msg").slideUp(500);
                });
            }
        }
    </script>
@endpush
