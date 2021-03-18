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
                    <h4 class="card-title" id="basic-layout-card-center">Lookups</h4>
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
                                    <label for="type">Lookup Type</label>
                                    <select class="select2 form-control @error('type') is-invalid @enderror" id="type" name="type" >
                                        <option value="0">Select Lookup Type</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->type}}"  {{(old('type')?old('type'):$data->type)==$type->type?'selected':''}} >{{$type->type}}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="lookup_name">Lookup Name</label>
                                    <input type="text" id="lookup_name" class="form-control @error('lookup_name') is-invalid @enderror"
                                           placeholder="Lookup Name" name="lookup_name" value=" {{old('lookup_name')?old('lookup_name'):$data->name}}" required />
                                    @error('lookup_name')
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


        $().ready(function () {
            $('form#building').submit(function (e) {
                e.preventDefault();

                var type = $.trim($('#type').val());

                if (type === 0 || type <= 0) {
                    toastr.warning(" Please Select lookup type!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
                url: "{{ route('config.lookups.update',$data->id) }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    var type = $.trim($('#type').val());
                    if (type == "" || type == null) {
                        toastr.warning("  Please Select lookup type!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                },
                success: function (result) {
                    if (result.error === false) {
                        $(".print-success-msg").css('display', 'block');
                        $(".print-success-msg").html(result.message);
                        $('#type').val(null).trigger('change');
                        $('#lookup_name').val('');
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
