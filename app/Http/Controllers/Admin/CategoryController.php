<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\CategoryDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CategoryDatatable $category) {
		return $category->render('admin.categories.index', ['title' => trans('admin.category_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.categories.create', ['title' => trans('admin.category_create')]);
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
		
		Category::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('categories'));
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
		
		$category = Category::findOrFail($id);
		$title = trans('admin.category_edit');
		return view('admin.categories.edit', compact('category', 'title'));
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
		
		Category::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('categories'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Category::findOrFail($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('categories'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			Category::destroy(request('item'));
		} else {
			Category::findOrFail(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('categories'));
	}
}
