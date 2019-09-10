<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\DistrictDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(DistrictDatatable $district) {
		return $district->render('admin.districts.index', ['title' => trans('admin.district_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.districts.create', ['title' => trans('admin.district_create')]);
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
				'city_id'   => 'required|numeric',
				
			], [], [
				'name_ar'      => trans('admin.name_ar'),
				'name_en'      => trans('admin.name_en'),
				'city_id'   => trans('admin.city_id'),

			]);
		
		District::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('districts'));
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
		
		$district = District::findOrFail($id);
		$title = trans('admin.district_edit');
		return view('admin.districts.edit', compact('district', 'title'));
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
			'city_id'   => 'required|numeric',
			
		], [], [
			'name_ar'      => trans('admin.name_ar'),
			'name_en'      => trans('admin.name_en'),
			'city_id'   => trans('admin.city_id'),

		]);
		
		District::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('districts'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {

		$district = District::findOrFail($id);
		$count1 = $district->clients()->count();
		$count2 = $district->restaurants()->count();
		if (!$count1 || !$count2)
		{
			$district->delete();

			session()->flash('success', trans('admin.deleted_name',['name'=> session('lang') == 'ar'?$district->name_ar:$district->name_en ]));
			return redirect(aurl('districts'));
			
		}

		session()->flash('error', trans('admin.you can not delete',['name'=> session('lang') == 'ar'?$district->name_ar:$district->name_en ]));
		return redirect(aurl('districts'));
	}




	public function multi_delete() {

		if (is_array(request('item'))) {

			foreach(request('item') as $item){

				$district = District::findOrFail($item);
				$count1 = $district->clients()->count();
				$count2 = $district->restaurants()->count();
				if (!$count1 || !$count2)
				{
					$district->delete();
					session()->flash('success', trans('admin.deleted_name',['name'=> session('lang') == 'ar'?$district->name_ar:$district->name_en ]));
				}else{
					session()->flash('error', trans('admin.you can not delete',['name'=> session('lang') == 'ar'?$district->name_ar:$district->name_en ]));
				}
				
			}
			
		} 

		return redirect(aurl('districts'));
	}

}
