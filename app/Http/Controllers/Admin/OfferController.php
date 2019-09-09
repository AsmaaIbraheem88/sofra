<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\OfferDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(OfferDatatable $offer) {
		return $offer->render('admin.offers.index', ['title' =>trans('admin.offer_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
	
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
		
	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Offer::findOrFail($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('offers'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			Offer::destroy(request('item'));
		} else {
			Offer::findOrFail(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('offers'));
	}
}
