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
                <h4 class="card-title" id="basic-layout-card-center">Create a Expense type</h4>
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
                                <label for="root_id"> Root Expense type <span class="required text-danger">*</span></label>
                                <select class="select2 form-control @error('root_id') is-invalid @enderror" id="root_id" name="root_id" required>
                                        <option value="0">Select Expense type</option>
                                        @foreach($rootTypes as $rootType)
                                                <option value="{{$rootType->id}}" {{ old('root_id')==$rootType->id?'selected':'' }}>{{$rootType->name}}</option>
                                        @endforeach
                                </select>
                                @error('root_id')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Expense Type Name </label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Expense Type Name" name="name" value="{{old('name')?old('name'):''}}" />
                                @error('name')
                                <div class="help-block text-danger">{{ $message }} </div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description <span class="required text-danger">*</span></label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Description" name="description" required>{{old('description')?old('description'):''}}</textarea>
                                @error('description')
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
        $('form#customer').submit(function (e) {
            e.preventDefault();

            var root_id = $.trim($('#root_id').val());
            var name = $.trim($('#name').val());


            if (root_id == 0 || root_id <= 0) {
                toastr.warning(" Please Select Root Expense type!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            } else if (name ==='') {
                toastr.warning(" Please enter customer name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
            url: "{{ route('accounts.expense-types.store') }}",
            type: 'post',
            dataType: "json",
            cache: false,
            data: $('form').serialize(),
            beforeSend: function () {
                var name = $.trim($('#name').val());
                if (name == "" || name == null) {
                    toastr.warning(" Please enter expense type name!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
            },
            success: function (result) {
                if (result.error === false) {
                    $(".print-success-msg").css('display', 'block');
                    $(".print-success-msg").html(result.message);
                    $('#root_id').val(null).trigger('change');
                    $('#name').val('');
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
