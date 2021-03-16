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
                <h4 class="card-title" id="basic-layout-card-center">Floors</h4>
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
                                <label for="building_name">Building Name</label>
                                <select class="select2 form-control @error('building_name') is-invalid @enderror" id="building_name" name="building_name" >
                                        <option value="0">Select Building Name</option>
                                        @foreach($buildings as $building)
                                            @if($building->id == old('building_name'))
                                                <option value="{{$building->id}}" selected>{{$building->name}}</option>
                                            @else
                                                <option value="{{$building->id}}">{{$building->name}}</option>
                                            @endif
                                        @endforeach
                                </select>
                                @error('building_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="floor_name">Floor Name</label>
                                <select class="select2 form-control @error('floor_name') is-invalid @enderror" id="floor_name" name="floor_name" >
                                    <option value="0">Select Floor Name</option>

                                </select>
                                @error('floor_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="flat_name">Flat Name</label>
                                <textarea id="flat_name" class="form-control @error('flat_name') is-invalid @enderror"
                                          placeholder="Flat Name" name="flat_name">{{old('flat_name')?old('flat_name'):''}}</textarea>
                                @error('flat_name')
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

    $().ready(function () {
        $('form#building').submit(function (e) {
            e.preventDefault();

            var building_name = $.trim($('#building_name').val());

            var floor_name = $.trim($('#floor_name').val());

            var flat_name = $.trim($('#flat_name').val());

            if (building_name === 0 || building_name <= 0) {
                toastr.warning(" Please Select building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (floor_name === 0 || floor_name <= 0) {
                toastr.warning(" Please enter floor name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (flat_name === '') {
                toastr.warning(" Please enter flat name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('crm.flats.store') }}",
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
                    $('#flat_name').val('');
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
