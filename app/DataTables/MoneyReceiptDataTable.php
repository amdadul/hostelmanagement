<?php

namespace App\DataTables;


use App\Modules\Accounts\Models\MoneyReceipt;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MoneyReceiptDataTable extends DataTable
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
                            <a href='money-receipt/$data->id/edit' class='btn btn-icon btn-secondary'><i class='fa fa-pencil-square-o'></i> Edit</a>
                            <a href='money-receipt/$data->voucher_no/voucher' class='btn btn-icon btn-info'><i class='fa fa-eye'></i> View</a>
                            <button data-remote='money-receipt/$data->id/delete' class='btn btn-icon btn-danger btn-delete'><i class='fa fa-trash-o'></i> Delete</button>
                        </div>
                   </div>";
            })
            ->editColumn('customer_id', function ($data) {
                return isset($data->customer->name) ? $data->customer->name . '<br>' . $data->customer->phone_no : 'N/A';
            })
            ->editColumn('invoice_id', function ($data) {
                return isset($data->invoice->invoice_no) ? $data->invoice->invoice_no : 'N/A';
            })
            ->editColumn('receipt_type', function ($data) {
                return $data->receipt_type == 1 ? 'Cash' : 'Advance';
            })
            ->rawColumns(['action', 'customer_id'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param MoneyReceipt $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MoneyReceipt $model)
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
            ->setTableId('money-receipt-table')
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
            Column::make('invoice_id')->title('Invoice No'),
            Column::make('receipt_type')->title('Type'),
            Column::make('date'),
            Column::make('amount')->title('Total Amount'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Money_receipt' . date('YmdHis');
    }
}
