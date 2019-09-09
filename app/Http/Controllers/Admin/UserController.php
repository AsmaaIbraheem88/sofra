<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\UserDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(UserDatatable $user) {
		return $user->render('admin.users.index', ['title' => 'User Controller']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.users.create', ['title' => trans('admin.create_admin')]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		
		// dd($request->all());
		
        $this->validate($request, [
            'name' =>'required',
			'email'    => 'required|email|unique:users,email',
            'password'=>'required|confirmed', 
            // 'roles_list'=>'required',
        ], [], [
			'name'     => trans('admin.name'),
			'email'    => trans('admin.email'),
			'password' => trans('admin.password'),
		]);


        $request->merge(['password'=>bcrypt($request->password)]);
        $record = User::create($request->except('roles_list'));
        $record->roles()->attach($request->roles_list);

		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('users'));
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
		
		$user = User::find($id);
		$title = trans('admin.edit');
		return view('admin.users.edit', compact('user', 'title'));
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
			'email'    => 'required|email|unique:users,email,'.$id,
			'password' => 'sometimes|nullable|min:6'
		], [], [
			'name'     => trans('admin.name'),
			'email'    => trans('admin.email'),
			'password' => trans('admin.password'),
		]);
	
        $record = User::findOrFail($id);

        $record->name = $request->name;
        $record->email = $request->email;


        if(!empty($request->password))
        {

            $record->password = bcrypt($request->password);

        }

        $record->roles()->sync((array)$request->roles_list);

        $record->save();

        session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('users'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		User::find($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('users'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			User::destroy(request('item'));
		} else {
			User::find(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('users'));
	}
}
