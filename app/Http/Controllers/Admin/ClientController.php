<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\ClientDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( ClientDatatable $client) {
		return $client->render('admin.clients.index', ['title' =>trans('admin.client_list')]);
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

		$client = Client::findOrFail($id);
		$count = $client->comments()->count();
		if (!$count)
		{
			$client->delete();

			session()->flash('success', trans('admin.deleted_name',['name'=>$client->name ]));
			return redirect(aurl('clients'));
			
		}

		session()->flash('error', trans('admin.you can not delete',['name'=>$client->name ]));
		return redirect(aurl('clients'));
	}




	public function multi_delete() {

		if (is_array(request('item'))) {

			foreach(request('item') as $item){

				$client = Client::findOrFail($item);
				$count = $client->comments()->count();
				if (!$count)
				{
					$client->delete();
					session()->flash('success', trans('admin.deleted_name',['name'=>$client->name ]));
				}else{
					session()->flash('error', trans('admin.you can not delete',['name'=>$client->name ]));
				}
				
			}
			
		} 

		return redirect(aurl('clients'));
	}







	public function activated($id)
    
    {
        
		 $client = Client::findOrFail($id);

        if($client->is_active ==='inactive'){

			$client->is_active = 'active';
			$client->save();
			session()->flash('success', trans('admin.activate_successfully'));
			
            

        }else if($client->is_active ==='active'){

			$client->is_active = 'inactive';
			$client->save();
			session()->flash('success', trans('admin.de-activate successfully'));
			

        }

        return redirect(aurl('clients'));

    }


}
