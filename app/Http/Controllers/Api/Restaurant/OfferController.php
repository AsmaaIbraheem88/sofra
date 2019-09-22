<?php

namespace App\Http\Controllers\Api\Restaurant;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
     public function newOffer(Request $request )

     {
      
      $validator = validator()->make($request->all(),[

        'content_ar' => 'required',
        'title_ar' => 'required',
        'content_en' => 'required',
        'title_en' => 'required',
        'start_date' => 'required|date|date_format:Y-m-d H:i:s',
        'end_date' =>'required|date|date_format:Y-m-d H:i:s|after:start_date',
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
          $path = $request->file('image')->storeAs('public/offers', $fileNameToStore);

          $offer->image = $fileNameToStore;


        }

        $offer->save();
      

      return responseJson('1','تم الاضافه بنجاح',$offer);
    }


    /////////////////////////////////////////////////////////////////
    public function updateOffer(Request $request)
    {
      

      $validator = validator()->make($request->all(),[
        'offer_id' => 'required|exists:offers,id',
        'content_ar' => 'required',
        'title_ar' => 'required',
        'content_en' => 'required',
        'title_en' => 'required',
        'start_date' => 'required|date|date_format:Y-m-d H:i:s',
        'end_date' =>'required|date|date_format:Y-m-d H:i:s|after:start_date',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        
      ]);

   
    if($validator->fails())
    {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

    }


    $offer = $request->user()->offers()->find($request->offer_id);
    if (!$offer)
    {
        return responseJson(0,'لا يمكن الحصول على البيانات');
    }
    
     
    $offer->update($request->except(['image']));


    if($request->hasFile('image')){

      Storage::delete('public/offers/'. $offer->image);

      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      // get file name
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      // get extension
      $extension = $request->file('image')->getClientOriginalExtension();

      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      // upload
      $path = $request->file('image')->storeAs('public/offers', $fileNameToStore);

      $offer->image = $fileNameToStore;



    };

    $offer->save();

    return responseJson(1,'تم تحديث البيانات',$offer);


  }

/////////////////////////////////////////////////////////////////////////
public function deleteOffer(Request $request)
{

  $offer = $request->user()->offers()->find($request->offer_id);
  if (!$offer)
  {
      return responseJson(0,'لا يمكن الحصول على البيانات');
  }

  Storage::delete('public/offers/'. $offer->image);

  $offer->delete();

  return responseJson('1','تم الحذف');


} 


  ///////////////////////////////////////////////////////////////


}
