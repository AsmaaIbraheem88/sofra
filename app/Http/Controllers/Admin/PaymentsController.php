<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\PaymentsDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(PaymentsDatatable $payment) {
		return $payment->render('admin.payments.index', ['title' => trans('admin.payments_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.payments.create', ['title' => trans('admin.payments_create')]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
	
		
		$data = $this->validate(request(),
			[
				'amount'    => 'required',
				'restaurant_id' => 'required|numeric'
			], [], [
				'amount'     => trans('admin.amount'),
				'restaurant_id'    =>trans('admin.restaurant_id'),
			]);
		
		Payment::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('payments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		
		$payment = Payment::findOrFail($id);
		$title = trans('admin.payments_edit');
		return view('admin.payments.edit', compact('payment', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		
		$data = $this->validate(request(),
		[
			'amount'    => 'required',
			'restaurant_id' => 'required|numeric'
		], [], [
			'amount'     => trans('admin.amount'),
			'restaurant_id'    =>trans('admin.restaurant_id'),
		]);
	
		
		Payment::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('payments'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Payment::findOrFail($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('payments'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			Payment::destroy(request('item'));
		} else {
			Payment::findOrFail(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('payments'));
	}
}
