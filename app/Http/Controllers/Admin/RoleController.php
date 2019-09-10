<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\RoleDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(RoleDatatable $role) {
		return $role->render('admin.roles.index', ['title' => trans('admin.role_list')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('admin.roles.create', ['title' => trans('admin.role_create')]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		 // dd($request->all());
		 $rules = [
            
			'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permissions_list' => 'required|array'
            
        ];

        $message = [
            'name.required'=>' Name Is Required',
            'name.unique'=>'This Name Exist',
            'display_name.required'=>' Display Name Is Required',
            'permissions_list.required'=>' permissions_list Is Required',
            
        ];

        $this->validate($request, $rules,$message);

        $record = Role::create($request->all());

        $record->permissions()->attach($request->permissions_list);

	
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('roles'));
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
		
		$role = Role::findOrFail($id);
		$title = trans('admin.role_edit');
		return view('admin.roles.edit', compact('role', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		
	
		$rules = [

            'name' => [
                'required',
                 Rule::unique('roles')->ignore($id),
            ],
            'display_name'=>'required',
			'permissions_list'=>'required|array',
			
		    
        ];

        $message = [
            'name.required'=>' Name Is Required',
            'name.unique'=>'This Name Exist',
            'display_name.required'=>' Display Name Is Required',
            'permissions_list.required'=>' permissions_list Is Required',
            
        ];

        $this->validate($request, $rules,$message);

        $record = Role::findOrFail($id);

        $record->update($request->all());

        $record->permissions()->sync($request->permissions_list);


		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('roles'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {

		$role = Role::findOrFail($id);
		$count = $role->users()->count();
		if (!$count)
		{
			$role->delete();

			session()->flash('success', trans('admin.deleted_name',['name'=>$role->name ]));
			return redirect(aurl('roles'));
			
		}

		session()->flash('error', trans('admin.you can not delete',['name'=>$role->name ]));
		return redirect(aurl('roles'));
	}




	public function multi_delete() {

		if (is_array(request('item'))) {

			foreach(request('item') as $item){

				$role = Role::findOrFail($item);
				$count = $role->users()->count();
				if (!$count)
				{
					$role->delete();
					session()->flash('success', trans('admin.deleted_name',['name'=>$role->name ]));
				}else{
					session()->flash('error', trans('admin.you can not delete',['name'=>$role->name ]));
				}
				
			}
			
		} 

		return redirect(aurl('roles'));
	}

}
