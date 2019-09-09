<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Settings;
use App\Models\Contact;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\Restaurant;
use App\Models\PaymentMethod;
use App\Models\Meal;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Order;


use Mail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Mail\ContactUs;


class GeneralController extends Controller
{

    

    public function cities( )
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->paginate(10);
        return responseJson(1,'تم التحميل',$cities);
    }

    ////////////////////////////////////////////

    public function districts(Request $request )
    {
        $districts = District::where(function($query) use($request){
            if ($request->has('name')){
                $query->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->paginate(10);
        return responseJson(1,'تم التحميل',$districts);
    }

    ////////////////////////////////////////////

    public function categories( )
    {
        $categories = Category::all();

        return responseJson('1','success',$categories);

    }

    ////////////////////////////////////////////

    public function settingsAll( )
    {
       return responseJson(1, 'loaded', setting());
        
    }

    ///////////////////////////////////////////////////

    public function paymentMethods( )
    {
        $paymentMethods = PaymentMethod::all();

        return responseJson('1','success',$paymentMethods);
    }

    ///////////////////////////////////////////////////
    
    public function restaurants(Request $request)//// with filter//
    {
       
        $restaurants = Restaurant::with('district','categories')->where(function($query) use($request){

            if ($request->input('city_id'))
            {
                $query->whereHas('district',function($query) use ($request){
                    $query->where('districts.city_id',$request->city_id);
                });
            }
            // city & (title || phone)
            if ($request->input('keyword'))
            {
                $query->where(function($query) use($request){
                    $query->where('name','like','%'.$request->keyword.'%')
                    ->orWhere('phone','like','%'.$request->keyword.'%');
                });
            }

        })->has('meals')->with('district', 'categories')->activated()->paginate(20);
        return responseJson(1, 'success', $restaurants);

        
    }

    ///////////////////////////////////////////////////

    public function restaurant(Request $request)
    {
       
        $restaurant = Restaurant::with('district','categories')->activated()->find($request->restaurant_id);

        if (!$restaurant) {
            return responseJson(0, '404 no restaurant found');
        }

        return responseJson(1, 'success', $restaurant);
    }


    ///////////////////////////////////////////////////

    public function meals(Request $request)
    {
        $meals = Meal::where('restaurant_id',$request->restaurant_id)->enabled()->paginate(10);

        return responseJson('1','success',$meals);
    }

    ///////////////////////////////////////////////////

    public function meal(Request $request)
    {
        $meal = Meal::find($request->meal_id);

        if (!$meal) {
            return responseJson(0, '404 no meal found');
        }

        return responseJson('1','success',$meal);
    }

    ///////////////////////////////////////////////////

    public function comments( Request $request)
    {
        $restuarant = Restaurant::find($request->restaurant_id);
        if (!$restuarant)
        {
            return responseJson(0,'no data');
        }
        $comments = $restuarant->comments()->paginate(10);
        return responseJson(1,'success',$comments);
    }

    ///////////////////////////////////////////////////


    public function offers( Request $request )
    {
        $now = Carbon::now()->toDateTimeString();

        $offers = Offer::where(function($offer) use($request){

            if($request->has('restaurant_id'))
            {
                $offer->where('restaurant_id',$request->restaurant_id);
            }
        })->where('start_date', '<=', $now)->where('end_date', '>=', $now)->has('restaurant')->with('restaurant')->latest()->paginate(20);


        return responseJson('1','success',$offers);

      
    }

    ///////////////////////////////////////////////////

    public function offer( Request $request)
    {
        $offer = Offer::with('restaurant')->find($request->offer_id);

        if (!$offer) {
            return responseJson(0, '404 no offer found');
        }
      
        return responseJson('1','success',$offer);
    }

    ///////////////////////////////////////////////////   

    public function contact(Request $request )
    {

        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'subject' => 'required',
           // 'type' => 'required|in:complaint,suggestion,inquiry',
            'type' => [
                'required',
                 Rule::in(['complaint', 'suggestion','enquiry']),
            ],
            'email' => 'required|email',
            'message' => 'required'
            ]);
     
           if($validator->fails())
          {
            $data = $validator->errors();
            return responseJson('0',$validator->errors()->first(),$data);
    
          }
        
    
            $contact = Contact::create($request->all()); //we can use this only and  not send mail
    
          Mail::to('laravelemail2019@gmail.com') //   Mail::to(setting()->email)
                   ->send(new ContactUs( $contact));
    
                   return responseJson('1','Thanks for contacting us!');
    
    }

    ////////////////////////////////////////////////

  
    
}



