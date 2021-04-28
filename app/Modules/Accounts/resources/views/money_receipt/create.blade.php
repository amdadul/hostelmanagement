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

        .bank_other_payment, .cash_payment_bank {
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
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" id="mr-form" action="{{route('accounts.money-receipt.store')}}"
                                  method="post" autocomplete="off">
                                @csrf
                                <div class="form-body">
                                    <div class="tab-1">
                                        <h4 class="form-section" style="color: #0c0c0c;"><i class="ft-user"></i> Applicant Info</h4>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name</label>
                                                    <input type="text"
                                                           class="form-control @error('customer_name') is-invalid @enderror"
                                                           id="customer_name"  autocomplete="off">
                                                    <input type="hidden"
                                                           class="form-control @error('customer_id') is-invalid @enderror"
                                                           id="customer_id" name="customer_id" >
                                                    @error('customer_id')
                                                    <div class="help-block text-danger">{{ $message }} </div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="contact_no">Phone no</label>
                                                    <input type="text" class="form-control" id="contact_no" value="" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group" style="margin-top: 26px;">
                                                    <button id="action" class="btn btn-primary btn-md" type="button"
                                                            onclick="getDueInvoice()">
                                                        <i class="icon-magnifier"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        </div>

                                    <div class="spinner-div text-center" style="display: none;">
                                        <button type="button" class="btn btn-lg btn-success mb-1">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait..
                                        </button>
                                    </div>
                                    <div class="row" id="invoice-infos">
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

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }

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

        function getDueInvoice() {
            var customer_id = $("#customer_id").val();
            $.ajax({
                url: "{{ route('crm.invoice.due-invoice') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: {
                    _token: CSRF_TOKEN,
                    customer_id: customer_id,
                },
                beforeSend: function () {
                    if (customer_id == "" || customer_id == 0 || customer_id == null) {
                        toastr.warning(" Please select customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    $('#invoice-infos').html("");
                    $(".spinner-div").show();
                },
                success: function (data) {
                    if (data.success == true) {
                        //user_jobs div defined on page
                        $('#invoice-infos').html(data.html);
                    } else {
                        $(".invoice-infos").html("");
                    }
                    $(".spinner-div").hide();
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                }
            }).done(function (data) {
            }).fail(function (jqXHR, textStatus) {
                $(".spinner-div").hide();
                $(".invoice-infos").html("");
            });
        }

        $("#customer_name").autocomplete({
            minLength: 1,
            autoFocus: true,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('customer.name.autocomplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
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
                $.ajax({
                    url: "{{ route('customer.phone.autocomplete') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
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


        $().ready(function () {
            $('form#mr-form').submit(function (e) {
                e.preventDefault();
                // Get the Login Name value and trim it
                var date = $.trim($('#date').val());
                var customer_id = $.trim($('#customer_id').val());
                var payment_method = $.trim($('#payment_method').val());
                var bank_id = $.trim($('#bank_id').val());
                var cheque_no = $.trim($('#cheque_no').val());
                var cheque_date = $.trim($('#cheque_date').val());
                var grand_total = nanCheck(parseFloat($.trim($('#grand_total').val())));
                if (date === '') {
                    toastr.warning(" Please select  date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (customer_id === '') {
                    toastr.warning(" Please select  customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                if (payment_method === '' || payment_method <= 0) {
                    toastr.warning(" Please select  payment method!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                payment_method = nanCheck(payment_method);
                if (isValidCode(payment_method, bankArray)) {
                    if (bank_id === '' || bank_id <=0) {
                        toastr.warning(" Please select  bank!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    if (isValidCode(payment_method, paymentChequeArray)) {
                        if (cheque_no === '' || cheque_date === '') {
                            toastr.warning(" Please select  cheque no & cheque date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                            return false;
                        }
                    }
                }
                var rowCount = $('#table-data-list tbody tr.cartList').length;
                if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                    toastr.warning(" Please add at least one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    return false;
                }
                // console.log(grand_total);
                if (grand_total <= 0 || grand_total === "") {
                    toastr.warning(" Please insert mr amount!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
                url: "{{ route('accounts.money-receipt.store') }}",
                type: 'post',
                dataType: "json",
                cache: false,
                data: $('form').serialize(),
                beforeSend: function () {
                    if (customer_id == "" || customer_id == 0 || customer_id == null) {
                        toastr.warning(" Please select customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                        return false;
                    }
                    $('#invoice-infos').html("");
                    $(".spinner-div").show();
                },
                success: function (result) {
                    if(result.error === false){
                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").html(result.message);
                        $('.modal-body').html(result.data);
                        $('#xlarge').modal('show');
                        flashMessage('success');
                    }else{
                        printErrorMsg(result.data);
                        flashMessage('error');
                    }
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    $(".spinner-div").hide();
                    $(".invoice-infos").html("");
                }
            }).done(function (data) {
                console.log("REQUEST DONE;");
            }).fail(function (jqXHR, textStatus) {
                console.log("REQUEST FAILED;");
                $(".spinner-div").hide();
                $(".invoice-infos").html("");
            });
        }


        function resetCustomer()
        {
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
