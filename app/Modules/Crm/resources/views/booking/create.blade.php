@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@push('styles')
    <!-- CSS -->
    <style>
        .ui-datepicker {
            z-index: 999 !important;
        }
         .bank_other_payment, .amount, .cash_payment_bank {
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
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form">Booking Info</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="card-text">
                        </div>
                        <form class="form" id="booking-form" action="{{route('crm.seat-booking.store')}}" method="post" autocomplete="off">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="ft-user"></i> Order & Customer Info</h4>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="text"
                                                   class="form-control @error('start_date') is-invalid @enderror"
                                                   id="start_date" value="{!! date('Y-m-d') !!}" name="start_date" required>
                                            @error('start_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="text"
                                                   class="form-control @error('end_date') is-invalid @enderror"
                                                   id="end_date" value="{!! date('Y-m-d') !!}" name="end_date" required>
                                            @error('end_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
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
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text"
                                                   class="form-control @error('customer_name') is-invalid @enderror"
                                                   id="customer_name" required>
                                            <input type="hidden"
                                                   class="form-control @error('customer_id') is-invalid @enderror"
                                                   id="customer_id" name="customer_id" required>
                                            @error('customer_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="contact_no">Phone no</label>
                                            <input type="text" class="form-control" id="contact_no" value="">
                                        </div>
                                    </div>
                                </div>


                                <h4 class="form-section"><i class="fa fa-paperclip"></i> Payment Information</h4>

                                <div class="row">

                                    <div class="col-md-2 cash_payment">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method</label>
                                            <select id="payment_method" name="payment_method"
                                                    class="select2 form-control @error('payment_method') is-invalid @enderror">
                                                <option value="none" selected="">Select Payment method</option>
                                                @foreach($payment_type as $value)
                                                    <option value="{{ $value->code }}"> {{ $value->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('payment_method')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 bank_other_payment">
                                        <div class="form-group">
                                            <label for="bank_id">Bank</label>
                                            <select id="bank_id" name="bank_id"
                                                    class="select2 form-control @error('bank_id') is-invalid @enderror">
                                                <option value="none" selected="">Select Bank</option>
                                                @foreach($bank as $bnk)
                                                    <option value="{{ $bnk->code }}"> {{ $bnk->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('bank_id')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 bank_other_payment">
                                        <div class="form-group">
                                            <label for="cheque_no">Cheque/Transaction No</label>
                                            <input type="text"
                                                   class="form-control @error('cheque_no') is-invalid @enderror"
                                                   id="cheque_no" name="cheque_no">
                                            @error('cheque_no')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 bank_other_payment">
                                        <div class="form-group">
                                            <label for="cheque_date">Cheque Date</label>
                                            <input type="text"
                                                   class="form-control @error('cheque_date') is-invalid @enderror"
                                                   id="cheque_date" name="cheque_date">
                                            @error('cheque_date')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 amount">
                                        <div class="form-group">
                                            <label for="service_charge">Service Charge</label>
                                            <input type="service_charge"
                                                   class="form-control @error('service_charge') is-invalid @enderror"
                                                   id="service_charge" name="service_charge">
                                            @error('service_charge')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 amount">
                                        <div class="form-group">
                                            <label for="advance">Advance</label>
                                            <input type="advance"
                                                   class="form-control @error('advance') is-invalid @enderror"
                                                   id="advance" name="advance">
                                            @error('advance')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 amount">
                                        <div class="form-group">
                                            <label for="total">Total</label>
                                            <input type="total"
                                                   class="form-control @error('total') is-invalid @enderror"
                                                   id="total" name="total" readonly>
                                            @error('total')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>

                                </div>


                                <h4 class="form-section"><i class="fa fa-paperclip"></i> Seat Information</h4>

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="floor_name">Floor Name </label>
                                            <select class="select2 form-control @error('floor_name') is-invalid @enderror" id="floor_name" name="floor_name" >
                                                <option value="0">Select Floor Name</option>

                                            </select>
                                            @error('floor_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="flat_name">Flat Name</label>
                                            <select class="select2 form-control @error('flat_name') is-invalid @enderror" id="flat_name" name="flat_name" >
                                                <option value="0">Select Flat Name</option>

                                            </select>
                                            @error('flat_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="room_name">Room Name </label>
                                            <select class="select2 form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" >
                                                <option value="0">Select Room Name</option>

                                            </select>
                                            @error('room_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="seat_name">Seat Name </label>
                                            <select class="select2 form-control @error('seat_name') is-invalid @enderror" id="seat_name" name="seat_name" >
                                                <option value="0">Select Seat Name</option>

                                            </select>
                                            @error('seat_name')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="booking_price">Booking Price</label>
                                            <input type="text"
                                                   class="form-control @error('booking_price') is-invalid @enderror"
                                                   id="booking_price" name="booking_price" onkeyup="calculateTotal();">
                                            @error('booking_price')
                                            <div class="help-block text-danger">{{ $message }} </div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group" style="margin-top: 26px;">
                                            <button id="action" class="btn btn-primary btn-md" type="button"
                                                    onclick="add()">
                                                <i class="icon-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table table-responsive">
                                            <table class="table table-bordered table-hover " id="table-data-list">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Building Name</th>
                                                    <th>Floor</th>
                                                    <th>Flat</th>
                                                    <th>Room</th>
                                                    <th>Seat</th>
                                                    <th>Booking Price</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="6" class="text-right">Grand Total</th>
                                                    <th style="text-align: center;">
                                                        <div id="grand_total_text"></div>
                                                        <input type="hidden" id="grand_total" name="grand_total">
                                                    </th>
                                                    <th></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-refresh-ccw"></i> Reload
                                </button>
                                <button type="submit" class="btn btn-primary" name="saveInvoice">
                                    <i class="fa fa-check-square-o"></i> Save
                                </button>
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

        $("#service_charge").keyup(function () {
            calculateTotal()
        });
        $("#advance").keyup(function () {
            calculateTotal()
        });

        function nanCheck(value) {
            return isNaN(value) ? 0 : value;
        }
        function isValidCode(code, codes) {
            return ($.inArray(code, codes) > -1);
        }

        function calculateTotal()
        {
            var service_charge =nanCheck($("#service_charge").val())?nanCheck($("#service_charge").val()):0;
            var advance = nanCheck($("#advance").val())?nanCheck($("#advance").val()):0;
            var total =  parseFloat(service_charge)+ parseFloat(advance);
            $("#total").val( parseFloat(total));
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

        $('#seat_name').on('change', e => {
            $('#booking_price').empty();
            var seat_name = $.trim($('#seat_name').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('crm.seat-prices.get-price') }}",
                type: 'post',
                data: {'seat_id': seat_name},
                success: data => {
                    $('#booking_price').val(data.price)
                }
            })
        })

        function add() {
            var seat_id = $("#seat_name").val();
            var booking_price = parseFloat($("#booking_price").val());

            var message;
            var error = true;
            if (seat_id === '' || seat_id == 0) {
                message = "Please select a Seat!";
            } else if (booking_price <= 0 || booking_price === '') {
                message = "Please insert booking Price!";
            }  else {
                var isproductpresent = 'no';
                var temp_codearray = document.getElementsByName("product[temp_seat_id][]");
                if (temp_codearray.length > 0) {
                    for (var l = 0; l < temp_codearray.length; l++) {
                        var code = temp_codearray[l].value;
                        if (code == seat_id) {
                            isproductpresent = 'yes';
                        }
                    }
                }
                if (isproductpresent === 'no') {
                    addNewRow();
                    calculateGrandTotal();
                    resetProduct();
                    error = false;
                    message = "Seat added to grid.";
                } else {
                    message = "Seat is already added to grid! Please try with another Seat!";
                }
            }
            if (error === true) {
                toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
            }
        }
        function addNewRow() {
            var building_name = $("#building_name :selected").text();
            var floor_name = $("#floor_name :selected").text();
            var flat_name = $("#flat_name :selected").text();
            var room_name = $("#room_name :selected").text();
            var seat_id = $("#seat_name").val();
            var seat_name = $("#seat_name :selected").text();
            var booking_price = parseFloat($("#booking_price").val());

            var slNumber = $('#table-data-list tbody tr.cartList').length + 1;
            var appendTxt = "<tr class='cartList'>"
            appendTxt += "<td class='count' style='text-align: center;'>" + slNumber + "</td>";
            appendTxt += "<td style='text-align: left;'>" + building_name + "</td>";
            appendTxt += "<td style='text-align: left;'>" + floor_name + "</td>";
            appendTxt += "<td style='text-align: left;'>" + flat_name + "</td>";
            appendTxt += "<td style='text-align: left;'>" + room_name + "</td>";
            appendTxt += "<td style='text-align: center;'>" + seat_name + "<input type='hidden' class='form-control temp_seat_id' readonly name='product[temp_seat_id][]' value='" + seat_id + "'></td>";
            appendTxt += "<td style='text-align: center;'><input type='text' class='form-control temp_booking_price ' name='product[temp_booking_price][]' onkeyup='calculateGrandTotal();' value='" + booking_price + "'></td>";
            appendTxt += "<td style='text-align: center;'><button title=\"remove\"  type=\"button\" class=\"rdelete dltBtn btn btn-danger btn-md\" onclick=\"deleteRows($(this))\"><i class=\"icon-trash\"></i></button></td>";
            appendTxt += "</tr>";
            var tbodyRow = $('#table-data-list tbody tr.cartList').length;
            if (tbodyRow >= 1)
                $("#table-data-list tbody tr:last").after(appendTxt);
            else
                $("#table-data-list tbody").append(appendTxt);
        }
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
            $('#floor_name').val('').trigger('change');
            $('#flat_name').val('').trigger('change');
            $('#room_name').val('').trigger('change');
            $('#seat_name').val('').trigger('change');
        }


    $().ready(function () {
        $('form#booking-form').submit(function () {

            var customer_id = $.trim($('#customer_id').val());
            var date = $('#start_date').val();
            var building_name = $.trim($('#building_name').val());


            if (date === '') {
                toastr.warning(" Please select start date!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            }
            if (customer_id === '') {
                toastr.warning(" Please select  customer!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
                return false;
            }

            var rowCount = $('#table-data-list tbody tr.cartList').length;
            if (nanCheck(rowCount) <= 0 || rowCount === 'undefined') {
                toastr.warning(" Please add at least one item to grid!", 'Message <i class="fa fa-bell faa-ring animated"></i>');
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
