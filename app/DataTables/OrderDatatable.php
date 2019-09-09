<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Services\DataTable;

class OrderDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
		    ->addColumn('show', 'admin.orders.btn.show')
			->rawColumns([
				'show',
			
				
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Order $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		return Order::query()->with('restaurant','client')->select('orders.*');
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html() {
		return $this->builder()
		            ->columns($this->getColumns())
			->minifiedAjax()
			->parameters([
				'dom'        => 'Blfrtip',
				'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, trans('admin.all_record')]],
				'buttons'    => [
				

					['extend' => 'print', 'className' => 'btn btn-primary', 'text' => '<i class="fa fa-print"></i>'],
					['extend' => 'csv', 'className' => 'btn btn-info', 'text' => '<i class="fa fa-file"></i> '.trans('admin.ex_csv')],
					['extend' => 'excel', 'className' => 'btn btn-success', 'text' => '<i class="fa fa-file"></i> '.trans('admin.ex_excel')],
					['extend' => 'reload', 'className' => 'btn btn-default', 'text' => '<i class="fa fa-refresh"></i>'],
					

				],
				'initComplete' => " function () {
		            this.api().columns([2,3,4]).every(function () {
		                var column = this;
		                var input = document.createElement(\"input\");
		                $(input).appendTo($(column.footer()).empty())
		                .on('keyup', function () {
		                    column.search($(this).val(), false, false, true).draw();
		                });
		            });
		        }",

				'language' => datatable_lang(),

			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns() {
		
		return [

			 [
				'name'  => 'id',
				'data'  => 'id',
				'title' => '#',
			], [
				'name'  => 'status',
				'data'  => 'status',
				'title' => trans('admin.status'),
			], [
				'name'  => 'price',
				'data'  => 'price',
				'title' => trans('admin.price'),
			], [
				'name'  => 'delivery_cost',
				'data'  => 'delivery_cost',
				'title' => trans('admin.delivery_cost'),
			], [
				'name'  => 'total_price',
				'data'  => 'total_price',
				'title' => trans('admin.total_price'),
			], [
				'name'  => 'commission',
				'data'  => 'commission',
				'title' => trans('admin.commission'),
			], [
				'name'  => 'notes',
				'data'  => 'notes',
				'title' => trans('admin.notes'),
			],  [
				'name'  => 'address',
				'data'  => 'address',
				'title' => trans('admin.address'),
			], [
				'name'  => 'restaurant.name',
				'data'  => 'restaurant.name',
				'title' => trans('admin.restaurant_id'),
			],[
				'name'  => 'client.name',
				'data'  => 'client.name',
				'title' => trans('admin.client_id'),
			], [
				'name'  => 'created_at',
				'data'  => 'created_at',
				'title' => trans('admin.created_at'),
			], [
				'name'  => 'updated_at',
				'data'  => 'updated_at',
				'title' => trans('admin.updated_at'),
			], 	[
				'name'       => 'show',
				'data'       => 'show',
				'title'      => trans('admin.show'),
				'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
				'searchable' => false,
				], 

		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'orders_'.date('YmdHis');
	}
}
