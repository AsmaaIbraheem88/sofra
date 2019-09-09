<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\DataTables\AdminDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(AdminDatatable $admin) {
		return $admin->render('admin.admins.index', ['title' => trans('admin.admin_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.admins.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$this->validate($request, [
            'name' =>'required',
			'email'    => 'required|email|unique:admins,email',
            'password'=>'required|confirmed|min:6', 
            // 'roles_list'=>'required',
        ], [], [
			'name'     => trans('admin.name'),
			'email'    => trans('admin.email'),
			'password' => trans('admin.password'),
		]);


        $request->merge(['password'=>bcrypt($request->password)]);
        $record = Admin::create($request->except('roles_list'));
        $record->roles()->attach($request->roles_list);

		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('admin'));





		
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
		$admin = Admin::findOrFail($id);
		$title = trans('admin.admin_edit');
		return view('admin.admins.edit', compact('admin', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

		$this->validate($request,
		[
			'name'     => 'required',
			'email'    => 'required|email|unique:admins,email,'.$id,
			'password' => 'sometimes|nullable|min:6'
		], [], [
			'name'     => trans('admin.name'),
			'email'    => trans('admin.email'),
			'password' => trans('admin.password'),
		]);
	
        $record = Admin::findOrFail($id);

        $record->name = $request->name;
        $record->email = $request->email;


        if(!empty($request->password))
        {

            $record->password = bcrypt($request->password);

        }

        $record->roles()->sync((array)$request->roles_list);

        $record->save();

        session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('admin'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Admin::findOrFail($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('admin'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			Admin::destroy(request('item'));
		} else {
			Admin::findOrFail(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('admin'));
	}
}
