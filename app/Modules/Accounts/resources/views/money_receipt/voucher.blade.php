@extends('admin.app')
@section('title') {{ isset($pageTitle)?$pageTitle:'Buildings' }} @endsection
@push('styles')
    @include('admin.datatable_styles')
@endpush

@section('content')
    @include('admin.master.flash')

    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('accounts.money-receipt.create') }}" class="btn btn-icon btn-secondary"><i class="fa fa-backward"></i> Go
            Back</a>
        <a href="{{ route('accounts.money-receipt.index') }}" class="btn btn-icon btn-secondary"><i class="fa fa-list-ul"></i>
            Money Receipt Manage</a>
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
                             src="{{asset('app-assets/images/city_logo.png')}}"
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
                    <h2>MONEY RECEIPT VOUCHER</h2>
                    <p class="pb-3"># {{ $data->first()->voucher_no }}</p>
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-12 text-center text-md-left">
                    <p class="text-muted">Receive From</p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800">{{ $data->first()->customer->name }}</li>
                        <li>{{ $data->first()->customer->address }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p>
                        <span
                            class="text-muted">Date :</span> {{  date("F jS, Y", strtotime($data->first()->date)) }}</li>
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
                                <th>Invoice No</th>
                                <th class="text-right">Amount</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Row Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total = $rcvAmount = $disAmount = 0;
                            ?>
                            @foreach($data as $key => $dt)
                                <?php
                                $amount = $dt->amount;
                                $discount = $dt->discount;
                                $rowTotal = $amount + $discount;
                                $rcvAmount += $amount;
                                $disAmount += $discount;
                                $total += $rowTotal;
                                ?>
                                <tr>
                                    <th scope="row" style="width: 2%;">{{ ++$key }}</th>
                                    <td>
                                        <p>{{ isset($dt->invoice->invoice_no) ? $dt->invoice->invoice_no : "N/A" }}</p>
                                    </td>
                                    <td class="text-right">{{ number_format($dt->amount,2) }}</td>
                                    <td class="text-right">{{ number_format($dt->discount,2) }}</td>
                                    <td class="text-right">{{ number_format($rowTotal,2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-right"> <?= number_format($total, 2) ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <br>
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
