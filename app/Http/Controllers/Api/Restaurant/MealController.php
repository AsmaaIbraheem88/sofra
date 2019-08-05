<?php

namespace App\Http\Controllers\Api\Restaurant;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Meal;

use Illuminate\Support\Facades\File;

class MealController extends Controller
{
     public function create(Request $request )

     {

      $validator = validator()->make($request->all(),[

        'name' => 'required',
        'processing_time' => 'required',
        'description' => 'required',
        'discount_price' => 'required',
        'price' => 'required',
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
          $path = $request->file('image')->storeAs('public/admin/images/meals', $fileNameToStore);

          $meal->image = $fileNameToStore;


        };

       

        $meal->save();
        

      return responseJson('1','تم الاضافه بنجاح',$meal);
    }


    /////////////////////////////////////////////////////////////////
    public function update(Request $request,$id)
    {
      

      $validator = validator()->make($request->all(),[

        'name' => 'required',
        'processing_time' => 'required',
        'description' => 'required',
        'discount_price' => 'required',
        'price' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        
      ]);

   
    if($validator->fails())
    {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

    }


    $meal = Meal::find($id);

    if (!$meal) {
      return responseJson(0, '404 no meal found');
    }

     
    $meal->update($request->except(['image']));


    if($request->hasFile('image')){

      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      // get file name
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      // get extension
      $extension = $request->file('image')->getClientOriginalExtension();

      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      // upload
      $path = $request->file('image')->storeAs('public/admin/images/meals/', $fileNameToStore);

      //  $oldFilename=$meal->image;

      $meal->image = $fileNameToStore;

      //  File::delete(public_path('public/admin/images/meals/'. $oldFilename));


    };

    $meal->save();

    return responseJson(1,'تم تحديث البيانات',$meal);


  }

/////////////////////////////////////////////////////////////////////////
public function delete(Request $request,$id )
{

   $meal=  Meal::find($id);

  if (!$meal) {
    return responseJson(0, '404 no meal found');
  }

  // \Storage::delete($meal->image);

  $meal->delete();

  return responseJson('1','تم الحذف');


} 


  ///////////////////////////////////////////////////////////////


}
