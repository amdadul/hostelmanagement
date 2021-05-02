@extends('admin.app')
@section('title') {{ isset($pageTitle)?$pageTitle:'Seats' }} @endsection
@push('styles')
    @include('admin.datatable_styles')
@endpush

@section('content')
    @include('admin.master.flash')

    <div class="row">
        <div class="col-12 text-right">
            <a type="button" class="btn btn-info btn-min-width mr-1 mb-1"
               href="{{route('accounts.money-receipt.create')}}"><i
                    class="fa fa-plus"></i> Add New</a>
        </div>
    </div>

    <!-- Responsive integration (Bootstrap) table -->
    <section id="bs-responsive">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">MONEY RECEIPT</h4>
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
                        <div class="card-body card-dashboard">
                            {!! $dataTable->table([], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="row my-2">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
                <!-- Modal -->
                <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel16"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content" style="min-width: 900px !important;">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel16">Voucher</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close
                                </button>
                                <button type="button" class="btn btn-outline-primary">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('admin.datatable_scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $('#money-receipt-table').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            if (confirm('Are you sure you want to delete this row?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    $('#money-receipt-table').DataTable().draw(false);
                    var message = data.message;
                    if (data.success === true) {
                        toastr.success(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    } else {
                        if (!message)
                            message = "Please try again!";
                        toastr.error(message, 'Message <i class="fa fa-bell faa-ring animated"></i>');
                    }
                });
            }
        });
    </script>
@endpush
