<?php

namespace App\DataTables;


use App\Modules\Crm\Models\Building;
use App\Modules\Crm\Models\Flat;
use App\Modules\Crm\Models\Floor;
use App\Modules\Crm\Models\Room;
use App\Modules\Crm\Models\Seat;
use App\Modules\Crm\Models\SeatBooking;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SeatBookingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return "
                    <div class='form-group'>
                        <div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='seat-booking/$data->id/edit' class='btn btn-icon btn-secondary'><i class='fa fa-pencil-square-o'></i> Edit</a>
                            <a href='seat-booking/$data->id/voucher' class='btn btn-icon btn-info'><i class='fa fa-eye'></i> View</a>
                            <button data-remote='seat-booking/$data->id/delete' class='btn btn-icon btn-danger btn-delete'><i class='fa fa-trash-o'></i> Delete</button>
                        </div>
                   </div>";
            })
            ->editColumn('customer_id',function ($data){
                return isset($data->customer->name)?$data->customer->name.'<br>'.$data->customer->phone_no:'N/A';
            })
            ->editColumn('status',function ($data){
                return $data->status==1?'Active':'Leave The Seat';
            })
            ->rawColumns(['action','customer_id'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param SeatBooking $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SeatBooking $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('booking-table')
            ->setTableAttribute(['class' => 'table table-striped table-bordered dataex-fixh-responsive-bootstrap'])
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'select' => [
                    'style' => 'os',
                    'selector' => 'td:first-child',
                ],
                'buttons' => [
                    ['extend' => 'csv', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-file-excel-o"></i> csv</span>'],
                    ['extend' => 'excel', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-download"></i> excel<span class="caret"></span></span>'],
                    ['extend' => 'pdf', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-file-pdf-o"></i> pdf<span class="caret"></span></span>'],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-md no-corner', 'text' => '<span><i class="fa fa-print"></i> print</span>'],
                    'colvis'
                ],
                'initComplete' => "function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var input = document.createElement(\"input\");
                            input.className = 'form-control';
                            $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        });
                }",

            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('SL')
                ->render(null)
                ->width(100)
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false)
                ->footer('')
                ->exportable(true)
                ->printable(true),
            Column::make('voucher_no'),
            Column::make('customer_id')->title('Customer Info'),
            Column::make('booking_date'),
            Column::make('start_date')->title('Engage Date'),
            Column::make('grand_total')->title('Total Price'),
            Column::make('status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Seat_booking' . date('YmdHis');
    }
}
