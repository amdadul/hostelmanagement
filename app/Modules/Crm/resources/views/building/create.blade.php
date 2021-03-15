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
                <h4 class="card-title" id="basic-layout-card-center">Building</h4>
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
                                <input type="text" id="building_name" class="form-control @error('building_name') is-invalid @enderror"
                                       placeholder="Building Name" name="building_name" value="{{old('building_name')?old('building_name'):''}}">
                                @error('building_name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                          placeholder="Address" name="address">{{old('address')?old('address'):''}}</textarea>
                                @error('address')
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

    $().ready(function () {
        $('form#building').submit(function (e) {
            e.preventDefault();

            var building_name = $.trim($('#building_name').val());

            if (building_name === '') {
                toastr.warning(" Please enter building name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('crm.buildings.store') }}",
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
                    $('#building_name').val('');
                    $('#address').val('');
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
