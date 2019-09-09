<?php

namespace App\Http\Controllers\Api\Restaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Meal;

use Image;


class MealController extends Controller
{
     public function newMeal(Request $request )

     {

      $validator = validator()->make($request->all(),[

        'name_ar' => 'required',
        'name_en' => 'required',
        'description_ar' => 'required',
        'description_en' => 'required',
        'processing_time' => 'required',
        'discount_price' => 'required|numeric',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }

        $meal = $request->user()->meals()->create($request->all());
      
       
        if($request->hasFile('image')){

          $fileNameWithExt = $request->file('image')->getClientOriginalName();
          // get file name
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          // get extension
          $extension = $request->file('image')->getClientOriginalExtension();

          $fileNameToStore = $filename.'_'.time().'.'.$extension;
          // upload
          $path = $request->file('image')->storeAS('public/meals', $fileNameToStore);

          $meal->image = $fileNameToStore;

        };

        $meal->save();
      
      return responseJson('1','تم الاضافه بنجاح',$meal);
    }


    /////////////////////////////////////////////////////////////////
    public function updateMeal(Request $request)
    {
      

      $validator = validator()->make($request->all(),[

        'name_ar' => 'required',
        'name_en' => 'required',
        'description_ar' => 'required',
        'description_en' => 'required',
        'processing_time' => 'required',
        'discount_price' => 'required',
        'price' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        
      ]);

   
    if($validator->fails())
    {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

    }


    $meal = $request->user()->meals()->find($request->item_id);
    if (!$meal)
    {
        return responseJson(0,'لا يمكن الحصول على البيانات');
    }
     
    $meal->update($request->except(['image']));


    if($request->hasFile('image')){

      Storage::delete('public/meals/'. $meal->image);

      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      // get file name
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      // get extension
      $extension = $request->file('image')->getClientOriginalExtension();

      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      // upload
      $path = $request->file('image')->storeAS('public/meals', $fileNameToStore);


      $meal->image = $fileNameToStore;

    }

    $meal->save();

    return responseJson(1,'تم تحديث البيانات',$meal);


  }

/////////////////////////////////////////////////////////////////////////
public function deleteMeal(Request $request)
{

  $meal = $request->user()->meals()->find($request->item_id);

  if (!$meal)
  {
      return responseJson(0,'لا يمكن الحصول على البيانات');
  }

  if($meal->orders()->count())
  {
      $meal->update(['disabled' => 'disable']);
      return responseJson(1,'تم الحذف بنجاح');
  }

  Storage::delete('public/meals/'. $meal->image);

  $meal->delete();

  return responseJson('1','تم الحذف');


} 


  ///////////////////////////////////////////////////////////////


}
