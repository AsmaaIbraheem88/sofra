<?php

namespace App\DataTables;

use App\Models\Contact;
use Yajra\DataTables\Services\DataTable;

class ContactDatatable extends DataTable {
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query)
			->addColumn('checkbox', 'admin.contacts.btn.checkbox')
			->addColumn('delete', 'admin.contacts.btn.delete')
			->rawColumns([
				'delete',
				'checkbox'
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\Contact $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		return Contact::query();
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
				'name'  => 'name',
				'data'  => 'name',
				'title' => trans('admin.name'),
			],[
				'name'  => 'email',
				'data'  => 'email',
				'title' => trans('admin.email'),
			],
			[
				'name'  => 'subject',
				'data'  => 'subject',
				'title' => trans('admin.subject'),
			],[
				'name'  => 'message',
				'data'  => 'message',
				'title' => trans('admin.message'),
			],[
				'name'  => 'type',
				'data'  => 'type',
				'title' => trans('admin.type'),
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
		return 'contact_'.date('YmdHis');
	}
}
