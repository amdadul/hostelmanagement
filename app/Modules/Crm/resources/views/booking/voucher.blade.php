@extends('admin.app')
@section('title') {{ isset($pageTitle)?$pageTitle:'Buildings' }} @endsection
@push('styles')
    @include('admin.datatable_styles')
@endpush

@section('content')
    @include('admin.master.flash')

    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('crm.seat-booking.create') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go
            Back</a>
        <a href="{{ route('crm.seat-booking.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Invoice Manage</a>
        <a href="#" class="btn btn-icon btn-secondary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i>
            Print</a>
    </div>
    <section class="card" id="printableArea">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <div class="media">
                        <img class="" alt=""
                             title=""
                             src=""
                             style="height: 80px; width: 80px;">
                        <div class="media-body">
                            <ul class="ml-2 px-0 list-unstyled">
                                <li class="text-bold-800">City Hostel</li>
                                <li>71</li>
                                <li>Purbo Razabazar</li>
                                <li></li>
                                <li>+88012345678</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <h2>BOOKING VOUCHER</h2>
                    <p class="pb-3"># {{ $booking->voucher_no }}</p>
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-12 text-center text-md-left">
                    <p class="text-muted">Bill To</p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800">{{ $booking->customer->name }}</li>
                        <li>{{ $booking->customer->address }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p>
                        <span
                            class="text-muted">Booking Date :</span> {{  date("F jS, Y", strtotime($booking->booking_date)) }}</li>
                    </p>
                    <p>
                        <span
                            class="text-muted">Service Charge Voucher:</span> {{ isset($booking->service_charge->voucher_no)?$booking->service_charge->voucher_no:'N/A' }}
                    </p>
                    <p>
                        <span
                            class="text-muted">Advance Voucher :</span> {{ isset($booking->advance->voucher_no)?$booking->advance->voucher_no:'N/A' }}
                    </p>
                </div>
            </div>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
                <div class="row">
                    <div class="table-responsive col-sm-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Seat & Description</th>
                                <th class="text-right">Booking Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $salesTotal = 0;
                            ?>
                            @foreach($booking->seatBookingDetails as $key => $invD)
                                <?php
                                $salesTotal += $invD->price;
                                ?>
                                <tr>
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>Seat : {{ $invD->seat->name }} Room: {{ $invD->seat->room->name }} Flat: {{ $invD->seat->room->flat->name }}</p>
                                        <p>Floor : {{ $invD->seat->room->flat->floor->name }} Building: {{ $invD->seat->room->flat->floor->building->name }}</p>
                                    </td>
                                    <td class="text-right">{{ $invD->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <th class="text-right"> <?= number_format($salesTotal, 2) ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-7 col-sm-12 text-center text-md-left">
                        <?php
                        $total_mr = 0;
                        ?>
                        @if($booking->service_charge->collection_type >0 || $booking->advance->collection_type >0 )
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>

                                        @if(($booking->service_charge->collection_type?$booking->service_charge->collection_type:$booking->advance->collection_type) == \App\Modules\Config\Models\lookup::PAYMENT_CASH)
                                            <tr>
                                                <td>Payment Method:</td>
                                                <td class="text-right">Cash</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Bank name:</td>
                                                <td class="text-right">
                                                    {{ \App\Modules\Config\Models\lookup::getLookupByCode('bank',($booking->service_charge->bank_id?$booking->service_charge->bank_id:$booking->advance->bank_id)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cheque/Transaction No:</td>
                                                <td class="text-right">{{ ($booking->service_charge->cheque_no?$booking->service_charge->cheque_no:$booking->advance->cheque_no) }}</td>
                                            </tr>
                                        @endif
                                        <?php
                                            $paidAmount = (isset($booking->service_charge->amount)?$booking->service_charge->amount:0)+(isset($booking->advance->amount)?$booking->advance->amount:0);
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <p class="lead">Payment History</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td >Service Charge</td>
                                    <td class="pink text-right"> <?= number_format((isset($booking->service_charge->amount)?$booking->service_charge->amount:0), 2) ?></td>
                                </tr>
                                <tr>
                                    <td >Advance Payment</td>
                                    <td class="pink text-right"> <?= number_format((isset($booking->advance->amount)?$booking->advance->amount:0), 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Total Payment Made</td>
                                    <td class="pink text-right"> <?= number_format($paidAmount, 2) ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
