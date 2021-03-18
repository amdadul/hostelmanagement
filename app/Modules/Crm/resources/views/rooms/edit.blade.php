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
                <h4 class="card-title" id="basic-layout-card-center">Edit a Room</h4>
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
                                                <option value="{{$building->id}}" {{ (old('building_name')?old('building_name'):$data->flat->floor->building_id)==$building->id?'selected':'' }}>{{$building->name}}</option>
                                        @endforeach
                                </select>
                                @error('building_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="floor_name">Floor Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('floor_name') is-invalid @enderror" id="floor_name" name="floor_name" >
                                    <option value="0">Select Floor Name</option>
                                    @foreach($floors as $floor)
                                            <option value="{{$floor->id}}" {{ (old('floor_name')?old('floor_name'):$data->flat->floor_id)==$floor->id?'selected':'' }}>{{$floor->name}}</option>
                                    @endforeach
                                </select>
                                @error('floor_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="flat_name">Flat Name <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('flat_name') is-invalid @enderror" id="flat_name" name="flat_name" >
                                    <option value="0">Select Flat Name</option>
                                    @foreach($flats as $flat)
                                            <option value="{{$flat->id}}" {{ (old('flat_name')?old('flat_name'):$data->flat_id)==$flat->id?'selected':'' }}>{{$flat->name}}</option>
                                    @endforeach
                                </select>
                                @error('flat_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="room_name">Room Name <span class="required text-danger">*</span></label>
                                <input id="room_name" class="form-control @error('room_name') is-invalid @enderror"
                                       placeholder="Room Name" name="room_name" value="{{old('room_name')?old('room_name'):$data->name}}" />
                                @error('room_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
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

    $().ready(function () {
        $('form#building').submit(function (e) {
            e.preventDefault();

            var building_name = $.trim($('#building_name').val());

            var floor_name = $.trim($('#floor_name').val());

            if (building_name === 0 || building_name <= 0) {
                toastr.warning(" Please Select building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (floor_name === '') {
                toastr.warning(" Please enter Floor name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('crm.rooms.update',$data->id) }}",
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
                    $('#room_name').val('');
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
