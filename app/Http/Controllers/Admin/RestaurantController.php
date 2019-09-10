<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\RestaurantDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( RestaurantDatatable $restaurant) {
		return $restaurant->render('admin.restaurants.index', ['title' => trans('admin.restaurant_list')]);
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
		
		$restaurant = Restaurant::findOrFail($id);
		$title = trans('admin.restaurant_show');
		return view('admin.restaurants.show', compact('restaurant', 'title'));
		
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

		$restaurant = Restaurant::findOrFail($id);
		$count = $restaurant->orders()->count();
		if (!$count)
		{
			$restaurant->delete();

			session()->flash('success', trans('admin.deleted_name',['name'=>$restaurant->name ]));
			return redirect(aurl('restaurants'));
			
		}

		session()->flash('error', trans('admin.you can not delete',['name'=>$restaurant->name ]));
		return redirect(aurl('restaurants'));
	}




	public function multi_delete() {

		if (is_array(request('item'))) {

			foreach(request('item') as $item){

				$restaurant = Restaurant::findOrFail($item);
				$count = $restaurant->orders()->count();
				if (!$count)
				{
					$restaurant->delete();
					session()->flash('success', trans('admin.deleted_name',['name'=>$restaurant->name ]));
				}else{
					session()->flash('error', trans('admin.you can not delete',['name'=>$restaurant->name ]));
				}
				
			}
			
		} 

		return redirect(aurl('restaurants'));
	}


	public function activated($id)
    
    {
        
		
		
		 $restaurant = Restaurant::findOrFail($id);
        // $restaurant->activated = 0;
        // $restaurant->save();

        if($restaurant->is_active ==='inactive'){

			$restaurant->is_active = 'active';
			$restaurant->save();
			session()->flash('success', trans('admin.activate_successfully'));
			
            

        }else if($restaurant->is_active ==='active'){

			$restaurant->is_active = 'inactive';
			$restaurant->save();
			session()->flash('success', trans('admin.de-activate successfully'));
			

        }

        return redirect(aurl('restaurants'));

	}
	
	public function print($id){
        $restaurant = Restaurant::with('district')->findOrFail($id);
        return view('admin.layouts.print',compact('restaurant'));
    }


}
