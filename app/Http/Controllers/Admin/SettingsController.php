<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller {

	public function setting_view() {
		return view('admin.settings.settings', ['title' => trans('admin.settings')]);
	}

	public function setting_save(Request $request ) {
		
		 	$this->validate($request, [
				'logo' => v_image(),
				'icon' => v_image()], [],
			[
				'logo' => trans('admin.logo'),
				'icon' => trans('admin.icon')
			]);


			// $settings = Settings::findOrFail(1);
	
			if (request()->hasFile('logo')) {

				Storage::delete('public/settings/'.setting()->logo);

				$fileNameWithExt = $request->file('logo')->getClientOriginalName();
				// get file name
				$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
				// get extension
				$extension = $request->file('logo')->getClientOriginalExtension();
	  
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				// upload
				$path = $request->file('logo')->storeAs('public/settings', $fileNameToStore);
	  
				setting()->logo = $fileNameToStore;
				
			}

			if (request()->hasFile('icon')) {
			
				Storage::delete('public/settings/'.setting()->icon);

				$fileNameWithExt = $request->file('icon')->getClientOriginalName();
				// get file name
				$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
				// get extension
				$extension = $request->file('icon')->getClientOriginalExtension();
	  
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				// upload
				$path = $request->file('icon')->storeAs('public/settings', $fileNameToStore);
	  
				setting()->icon = $fileNameToStore;

			}

	
			setting()->update($request->all());
			setting()->save();
			session()->flash('success', trans('admin.updated_record'));
			return redirect(aurl('settings'));
       
	}
}
