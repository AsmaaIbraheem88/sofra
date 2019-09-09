<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\CityDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CityDatatable $city) {
		return $city->render('admin.cities.index', ['title' =>trans('admin.city_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.cities.create', ['title' => trans('admin.city_create')]);
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
				'name_ar'     => 'required',
				'name_en'     => 'required',
				
			], [], [
				'name_ar'      => trans('admin.name_ar'),
				'name_en'      => trans('admin.name_en'),
			]);
		
		
		City::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('cities'));
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
		
		$city = City::findOrFail($id);
		$title = trans('admin.city_edit');
		return view('admin.cities.edit', compact('city', 'title'));
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
			'name_ar'     => 'required',
			'name_en'     => 'required',
			
		], [], [
			'name_ar'      => trans('admin.name_ar'),
			'name_en'      => trans('admin.name_en'),
		]);
	
		
		City::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('cities'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		City::findOrFail($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('cities'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			City::destroy(request('item'));
		} else {
			City::findOrFail(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('cities'));
	}
}
