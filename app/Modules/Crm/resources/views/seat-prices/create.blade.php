@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
@include('admin.master.flash')

<div class="alert alert-danger print-error-msg " style="display:none">
    <ul></ul>
</div>

<div class="row justify-content-md-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-card-center">Create a Seat</h4>
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
                    <form class="form" id="building" method="post">
                        @csrf
                        <div class="form-body">

                            <div class="form-group">
                                <label for="building_name">Building Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('building_name') is-invalid @enderror" id="building_name" name="building_name" >
                                        <option value="0">Select Building Name</option>
                                        @foreach($buildings as $building)
                                                <option value="{{$building->id}}" {{ old('building_name')==$building->id?'selected':'' }}>{{$building->name}}</option>
                                        @endforeach
                                </select>
                                @error('building_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="floor_name">Floor Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('floor_name') is-invalid @enderror" id="floor_name" name="floor_name" >
                                    <option value="0">Select Floor Name</option>

                                </select>
                                @error('floor_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="flat_name">Flat Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('flat_name') is-invalid @enderror" id="flat_name" name="flat_name" >
                                    <option value="0">Select Flat Name</option>

                                </select>
                                @error('flat_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="room_name">Room Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" >
                                    <option value="0">Select Room Name</option>

                                </select>
                                @error('room_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>


                            <div class="form-group">
                                <label for="seat_name">Seat Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('seat_name') is-invalid @enderror" id="seat_name" name="seat_name" >
                                    <option value="0">Select Seat Name</option>

                                </select>
                                @error('seat_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>


                            <div class="form-group">
                                <label for="seat_price">Seat Price <span class="required text-danger">*</span></label>
                                <input id="seat_price" class="form-control @error('seat_price') is-invalid @enderror"
                                       placeholder="Seat Price" name="seat_price" value="{{old('seat_price')?old('seat_price'):''}}" />
                                @error('seat_price')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                        </div>

                        <div class="form-actions center">
                            <button type="reset" class="btn btn-warning mr-1">
                                <i class="fa fa-window-close"></i> Clear
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Save
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
            url: "{{ route('crm.rooms.get-room') }}",
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

    $('#room_name').on('change', e => {
        $('#seat_name').empty();
        var room_name = $.trim($('#room_name').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('crm.seats.get-seat') }}",
            type: 'post',
            data: {'room_id': room_name},
            success: data => {
                $('#seat_name').append(`<option value="0">Select Seat Name</option>`)
                data.forEach(seat =>
                    $('#seat_name').append(`<option value="${seat.id}">${seat.name}</option>`)
                )
            }
        })
    })

    $().ready(function () {
        $('form#building').submit(function (e) {
            e.preventDefault();

            var building_name = $.trim($('#building_name').val());

            var floor_name = $.trim($('#floor_name').val());

            var flat_name = $.trim($('#flat_name').val());

            var room_name = $.trim($('#room_name').val());

            var seat_name = $.trim($('#seat_name').val());

            var seat_price = $.trim($('#seat_price').val());

            if (building_name == 0 || building_name <= 0) {
                toastr.warning(" Please Select building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (floor_name == 0 || floor_name <= 0) {
                toastr.warning(" Please Select floor name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (flat_name === '' || flat_name == 0) {
                toastr.warning(" Please Select flat name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (room_name === '' || room_name == 0) {
                toastr.warning(" Please Select room name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (seat_name === '') {
                toastr.warning(" Please enter seat name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (seat_price === '' || seat_price <= 0) {
                toastr.warning(" Please enter seat Price!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('crm.seat-prices.store') }}",
            type: 'post',
            dataType: "json",
            cache: false,
            data: $('form').serialize(),
            beforeSend: function () {
                var building_name = $.trim($('#building_name').val());
                if (building_name == "" || building_name == null) {
                    toastr.warning(" Please enter building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
            },
            success: function (result) {
                if (result.error === false) {
                    $(".print-success-msg").css('display', 'block');
                    $(".print-success-msg").html(result.message);
                    $('#building_name').val(null).trigger('change');
                    $('#floor_name').val(null).trigger('change');
                    $('#flat_name').val(null).trigger('change');
                    $('#room_name').val(null).trigger('change');
                    $('#seat_name').val('');
                    flashMessage('success');
                } else {
                    printErrorMsg(result.data);
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
