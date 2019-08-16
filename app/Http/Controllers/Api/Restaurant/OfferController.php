<?php

namespace App\Http\Controllers\Api\Restaurant;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Offer;

use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
     public function newOffer(Request $request )

     {
      
      $validator = validator()->make($request->all(),[

        'content' => 'required',
        'title' => 'required',
        'start_date' => 'required|date_format:Y-m-d H:i:s',
        'end_date' =>'required|date_format:Y-m-d H:i:s|after:start_date',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }

        $offer = $request->user()->offers()->create($request->all());
      
       
        if($request->hasFile('image')){

          $fileNameWithExt = $request->file('image')->getClientOriginalName();
          // get file name
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          // get extension
          $extension = $request->file('image')->getClientOriginalExtension();

          $fileNameToStore = $filename.'_'.time().'.'.$extension;
          // upload
          $path = $request->file('image')->storeAs('public/admin/images/offers', $fileNameToStore);

          $offer->image = $fileNameToStore;


        };

       

        $offer->save();
        

      return responseJson('1','تم الاضافه بنجاح',$offer);
    }


    /////////////////////////////////////////////////////////////////
    public function updateOffer(Request $request)
    {
      

      $validator = validator()->make($request->all(),[
        'offer_id' => 'required|exists:offers,id',
        'content' => 'required',
        'title' => 'required',
        'start_date' => 'required|date_format:Y-m-d H:i:s',
        'end_date' =>'required|date_format:Y-m-d H:i:s|after:start_date',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        
      ]);

   
    if($validator->fails())
    {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

    }


    $offer = Offer::find($request->offer_id);
    

    if (!$offer) {
      return responseJson(0, '404 no offer found');
    }

    

     
    $offer->update($request->except(['image']));


    if($request->hasFile('image')){

      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      // get file name
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      // get extension
      $extension = $request->file('image')->getClientOriginalExtension();

      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      // upload
      $path = $request->file('image')->storeAs('public/admin/images/offers/', $fileNameToStore);

      //  $oldFilename=$meal->image;

      $offer->image = $fileNameToStore;

      //  File::delete(public_path('public/admin/images/offers/'. $oldFilename));


    };

    $offer->save();

    return responseJson(1,'تم تحديث البيانات',$offer);


  }

/////////////////////////////////////////////////////////////////////////
public function deleteOffer(Request $request)
{

  $validator = validator()->make($request->all(),[
    'offer_id' => 'required|exists:offers,id',
  ]);

  if($validator->fails())
  {
      $data = $validator->errors();
      return responseJson('0',$validator->errors()->first(),$data);

  }


   $offer=  Offer::find($request->offer_id);

  if (!$offer) {
    return responseJson(0, '404 no offer found');
  }
  

  // \Storage::delete($offer->image);

  $offer->delete();

  return responseJson('1','تم الحذف');


} 


  ///////////////////////////////////////////////////////////////


}
