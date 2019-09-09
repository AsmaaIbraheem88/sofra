<?php

namespace App\DataTables;

use App\Models\Offer;
use Yajra\DataTables\Services\DataTable;

class OfferDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
			->addColumn('checkbox', 'admin.offers.btn.checkbox')
			->addColumn('delete', 'admin.offers.btn.delete')
			->rawColumns([
				'delete',
				'checkbox'
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Offer $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		return Offer::query()->with('restaurant')->select('offers.*');
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
		//->addAction(['width' => '80px'])
		//->parameters($this->getBuilderParameters());
			->parameters([
				'dom'        => 'Blfrtip',
				'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, trans('admin.all_record')]],
				'buttons'    => [
					
					['extend'   => 'print', 'className'   => 'btn btn-primary', 'text'   => '<i class="fa fa-print"></i>'],
					['extend'   => 'csv', 'className'   => 'btn btn-info', 'text'   => '<i class="fa fa-file"></i> '.trans('admin.ex_csv')],
					['extend'   => 'excel', 'className'   => 'btn btn-success', 'text'   => '<i class="fa fa-file"></i> '.trans('admin.ex_excel')],
					['extend'   => 'reload', 'className'   => 'btn btn-default', 'text'   => '<i class="fa fa-refresh"></i>'],
					['text' => '<i class="fa fa-trash"></i> '.trans('admin.delete_all'), 'className' => 'btn btn-danger delBtn'],

				],
				'initComplete' => " function () {
		            this.api().columns([1,2,3]).every(function () {
		                var column = this;
		                var input = document.createElement(\"input\");
		                $(input).appendTo($(column.footer()).empty())
		                .on('keyup', function () {
		                    column.search($(this).val(), false, false, true).draw();
		                });
		            });
		        }",

				'language'         => datatable_lang() ,
			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */

	// 'restaurant_id', 'payment_date', 'amount'
	protected function getColumns() {

		return [
			[
				'name'       => 'checkbox',
				'data'       => 'checkbox',
				'title'      => '<input type="checkbox" class="check_all" onclick="check_all()" />',
				'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
				'searchable' => false,
			], 
			[
				'name'  => 'id',
				'data'  => 'id',
				'title' => '#',
			], [
				'name'  => 'content_ar',
				'data'  => 'content_ar',
				'title' => trans('admin.content_ar'),
			],[
				'name'  => 'title_ar',
				'data'  => 'title_ar',
				'title' => trans('admin.title_ar'),
			],[
				'name'  => 'content_en',
				'data'  => 'content_en',
				'title' => trans('admin.content_en'),
			],[
				'name'  => 'title_en',
				'data'  => 'title_en',
				'title' => trans('admin.title_en'),
			],[
				// 'name'  => 'district.name_'.session('lang'),
				// 'data'  => 'district.name_'.session('lang'),
				'name'  => 'restaurant.name',
				'data'  => 'restaurant.name',
				'title' => trans('admin.restaurant'),
			],
			[
				'name'  => 'start_date',
				'data'  => 'start_date',
				'title' => trans('admin.start_date'),
			],[
				'name'  => 'end_date',
				'data'  => 'end_date',
				'title' => trans('admin.end_date'),
			],[
				'name'  => 'created_at',
				'data'  => 'created_at',
				'title' => trans('admin.created_at'),
			], [
				'name'  => 'updated_at',
				'data'  => 'updated_at',
				'title' => trans('admin.updated_at'),
			],[
				'name'       => 'delete',
				'data'       => 'delete',
				'title'      => trans('admin.delete'),
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
		return 'offers_'.date('YmdHis');
	}
}
