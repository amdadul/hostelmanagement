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
                <h4 class="card-title" id="basic-layout-card-center">Create a Assets</h4>
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
                    <form class="form" id="assets" method="post">
                        @csrf
                        <div class="form-body">

                            <div class="form-group">
                                <label for="assets_type">Asset type <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('assets_type') is-invalid @enderror" id="assets_type" name="assets_type" required>
                                        <option value="0">Select Asset type</option>
                                        @foreach($assetTypes as $assetType)
                                                <option value="{{$assetType->id}}" {{ old('assets_type')==$assetType->id?'selected':'' }}>{{$assetType->name}}</option>
                                        @endforeach
                                </select>
                                @error('assets_type')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description <span class="required text-danger">*</span></label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Description" name="description" required>{{old('description')?old('description'):''}}</textarea>
                                @error('description')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="qty">Quantity </label>
                                <input type="text" id="qty" class="form-control @error('qty') is-invalid @enderror"
                                          placeholder="Quantity" name="qty" value="{{old('qty')?old('qty'):''}}" />
                                @error('qty')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="depreciation">Depreciation </label>
                                <input type="text" id="depreciation" class="form-control @error('depreciation') is-invalid @enderror"
                                       placeholder="Depreciation" name="depreciation" value="{{old('depreciation')?old('depreciation'):''}}" />
                                @error('depreciation')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="life_time">Life Time (Months)</label>
                                <input type="text" id="life_time" class="form-control @error('life_time') is-invalid @enderror"
                                       placeholder="Life Time" name="life_time" value="{{old('life_time')?old('life_time'):''}}" />
                                @error('life_time')
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
        $('form#assets').submit(function (e) {
            e.preventDefault();

            var assets_type = $.trim($('#assets_type').val());
            var description = $.trim($('#description').val());


            if (assets_type == 0 || assets_type <= 0) {
                toastr.warning(" Please Select Assets type!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (description ==='') {
                toastr.warning(" Please enter description!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('accounts.assets.store') }}",
            type: 'post',
            dataType: "json",
            cache: false,
            data: $('form').serialize(),
            beforeSend: function () {
                var description = $.trim($('#description').val());
                if (description == "" || description == null) {
                    toastr.warning(" Please enter description!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
            },
            success: function (result) {
                if (result.error === false) {
                    $(".print-success-msg").css('display', 'block');
                    $(".print-success-msg").html(result.message);
                    $('#assets_type').val(null).trigger('change');
                    $('#qty').val('');
                    $('#depreciation').val('');
                    $('#life_time').val('');
                    $('#description').val('');
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
