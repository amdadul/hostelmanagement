@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    @include('admin.master.flash')

    <div class="alert alert-danger print-error-msg " style="display:none">
        <ul></ul>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-card-center">Edit a Customer</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                            <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form" id="customer" method="post">
                            @csrf
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="building_name">Building Name <span class="required text-danger">*</span></label>
                                    <select class="select2 form-control @error('building_name') is-invalid @enderror" id="building_name" name="building_name" required>
                                        <option value="0">Select Building Name</option>
                                        @foreach($buildings as $building)
                                            <option value="{{$building->id}}" {{ (old('building_name')?old('building_name'):$data->building_id)==$building->id?'selected':'' }}>{{$building->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('building_name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="customer_name">Customer Name <span class="required text-danger">*</span></label>
                                    <input id="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                                           placeholder="Customer Name" name="customer_name" value="{{old('customer_name')?old('customer_name'):$data->name}}" required/>
                                    @error('customer_name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Customer Email </label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                           placeholder="Customer Email" name="email" value="{{old('email')?old('email'):$data->email}}" />
                                    @error('email')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="phone">Customer Phone <span class="required text-danger">*</span></label>
                                            <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                                   placeholder="Customer Phone" name="phone" value="{{old('phone')?old('phone'):$data->phone_no}}" required/>
                                            @error('phone')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nid">NID/ Birth Certificate No  <span class="required text-danger">*</span></label>
                                            <input id="nid" class="form-control @error('nid') is-invalid @enderror"
                                                   placeholder="NID/ Birth Certificate No" name="nid" value="{{old('nid')?old('nid'):$data->nid}}" required/>
                                            @error('nid')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address <span class="required text-danger">*</span></label>
                                    <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                              placeholder="Address" name="address" required>{{old('address')?old('address'):$data->address}}</textarea>
                                    @error('address')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="gender">Gender <span class="required text-danger">*</span></label>
                                            <select class="select2 form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                <option value="0">Select Gender</option>
                                                @foreach($genders as $gender)
                                                    <option value="{{$gender->code}}" {{ (old('gender')?old('gender'):$data->gender)==$gender->code?'selected':'' }}>{{$gender->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="religion">Religion <span class="required text-danger">*</span></label>
                                            <select class="select2 form-control @error('religion') is-invalid @enderror" id="religion" name="religion" required>
                                                <option value="0">Select Religion</option>
                                                @foreach($religions as $religion)
                                                    <option value="{{$religion->code}}" {{ (old('religion')?old('religion'):$data->religion)==$religion->code?'selected':'' }}>{{$religion->name}}</option>
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
                                            <label for="marital_status">Marital Status <span class="required text-danger">*</span></label>
                                            <select class="select2 form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status" required>
                                                <option value="0">Select Marital Status</option>
                                                @foreach($marital_statuses as $marital_status)
                                                    <option value="{{$marital_status->code}}" {{ (old('marital_status')?old('marital_status'):$data->marital_status)==$marital_status->code?'selected':'' }}>{{$marital_status->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('marital_status')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="profession">Profession <span class="required text-danger">*</span></label>
                                            <select class="select2 form-control @error('profession') is-invalid @enderror" id="profession" name="profession" required>
                                                <option value="0">Select Profession</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{$profession->code}}" {{ (old('profession')?old('profession'):$data->profession)==$profession->code?'selected':'' }}>{{$profession->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('profession')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="guardian_name">Guardian Name <span class="required text-danger">*</span></label>
                                    <input id="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror"
                                           placeholder="Guardian Name" name="guardian_name" value="{{old('guardian_name')?old('guardian_name'):$data->guardian_name}}" required/>
                                    @error('guardian_name')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="gphone">Guardian Phone No <span class="required text-danger">*</span></label>
                                            <input id="gphone" class="form-control @error('gphone') is-invalid @enderror"
                                                   placeholder="Guardian Phone No" name="gphone" value="{{old('gphone')?old('gphone'):$data->guardian_phone_no}}" required/>
                                            @error('gphone')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="relation">Relation with Guardian <span class="required text-danger">*</span></label>
                                            <select class="select2 form-control @error('relation') is-invalid @enderror" id="relation" name="relation" required>
                                                <option value="0">Select Relation</option>
                                                @foreach($relations as $relation)
                                                    <option value="{{$relation->code}}" {{ (old('relation')?old('relation'):$data->relation_with_guardian)==$relation->code?'selected':'' }}>{{$relation->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('relation')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-actions center">
                                <button type="reset" class="btn btn-warning mr-1">
                                    <i class="fa fa-window-close"></i> Clear
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');



        $().ready(function () {
            $('form#customer').submit(function (e) {
                e.preventDefault();

                var building_name = $.trim($('#building_name').val());
                var customer_name = $.trim($('#customer_name').val());
                var phone = $.trim($('#phone').val());
                var address = $.trim($('#address').val());


                if (building_name == 0 || building_name <= 0) {
                    toastr.warning(" Please Select building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                } else if (customer_name ==='') {
                    toastr.warning(" Please enter customer name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                } else if (phone ==='') {
                    toastr.warning(" Please enter customer phone no!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                } else if (address ==='') {
                    toastr.warning(" Please enter customer address!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                } else {
                    ajaxSave();
                }
            });
        });

        function ajaxSave() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.customers.update',$data->id) }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    var customer_name = $.trim($('#customer_name').val());
                    if (customer_name == "" || customer_name == null) {
                        toastr.warning(" Please enter customer name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                },
                success: function (result) {
                    if (result.error === false) {
                        $(".print-success-msg").css('display', 'block');
                        $(".print-success-msg").html(result.message);
                        $('#building_name').val(null).trigger('change');
                        $('#customer_name').val('');
                        $('#phone').val('');
                        $('#address').val('');
                        $('#nid').val('');
                        $('#email').val('');
                        $('#guardian_name').val('');
                        $('#gphone').val('');
                        $('#gender').val(null).trigger('change');
                        $('#religion').val(null).trigger('change');
                        $('#marital_status').val(null).trigger('change');
                        $('#profession').val(null).trigger('change');
                        $('#relation').val(null).trigger('change');
                        alartMessage(true,result.message);
                        flashMessage('success');
                    } else {
                        printErrorMsg(result.data);
                        alartMessage(false,result.message);
                        flashMessage('error');
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            }).done(function (data) {
                console.log("REQUEST DONE;");
            }).fail(function (jqXHR, textStatus) {
                console.log("REQUEST FAILED;");
            });
        }

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        function alartMessage(success,message)
        {
            if(success===true)
            {
                toastr.success(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
            }
            else
            {
                toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
            }
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
