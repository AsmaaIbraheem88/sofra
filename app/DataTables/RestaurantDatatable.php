<?php

namespace App\DataTables;

use App\Models\Restaurant;
use Yajra\DataTables\Services\DataTable;

class RestaurantDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
			->addColumn('checkbox', 'admin.restaurants.btn.checkbox')
			->addColumn('show', 'admin.restaurants.btn.show')
			->addColumn('is_active', 'admin.restaurants.btn.is_active')
			->addColumn('activated', 'admin.restaurants.btn.activated')
			->addColumn('delete', 'admin.restaurants.btn.delete')
			->rawColumns([
				'show',
				'delete',
				'is_active',
				'checkbox',
				'activated'
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Restaurant $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {

		
		return Restaurant::query()->with('district')->select('restaurants.*');
		
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
	protected function getColumns() {
		// 'name', 'email', 'phone', 'district_id', 'minimum_charge', 'delivery_cost', 'whatsapp', 'image', 'status'
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
				'name'  => 'name',
				'data'  => 'name',
				'title' => trans('admin.name'),
			], [
				'name'  => 'email',
				'data'  => 'email',
				'title' => trans('admin.email'),
			], [
				'name'  => 'phone',
				'data'  => 'phone',
				'title' => trans('admin.phone'),
			], [
				'name'  => 'district.name_'.session('lang'),
				'data'  => 'district.name_'.session('lang'),
				'title' => trans('admin.district'),
			],[
				'name'  => 'minimum_charge',
				'data'  => 'minimum_charge',
				'title' => trans('admin.minimum_charge'),
			], [
				'name'  => 'delivery_cost',
				'data'  => 'delivery_cost',
				'title' => trans('admin.delivery_cost'),
			], [
				'name'  => 'whatsapp',
				'data'  => 'whatsapp',
				'title' => trans('admin.whatsapp'),
			], [
				'name'  => 'status',
				'data'  => 'status',
				'title' => trans('admin.status'),
			], [
				'name'  => 'is_active',
				'data'  => 'is_active',
				'title' => trans('admin.is_active'),
			],
			 [
			'name'       => 'activated',
			'data'       => 'activated',
			'title'      => trans('admin.activated'),
			'exportable' => false,
			'printable'  => false,
			'orderable'  => false,
			'searchable' => false,
			], 
			[
			'name'       => 'show',
			'data'       => 'show',
			'title'      => trans('admin.show'),
			'exportable' => false,
			'printable'  => false,
			'orderable'  => false,
			'searchable' => false,
			], 
			[
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
		return 'restaurants_'.date('YmdHis');
	}
}
