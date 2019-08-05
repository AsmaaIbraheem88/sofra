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
        $cities = City::all();

        return  responseJson('1','success',$cities);
    }

    ////////////////////////////////////////////

    public function districts(Request $request )
    {
        $districts = District::where(function ($query) use($request){

            if($request->has('city_id'))
      
            {
             $query->where('city_id',$request->city_id);
      
            }
      
           })->get();
        

        return responseJson('1','success',$districts);
    }

    ////////////////////////////////////////////

    public function categories( )
    {
        $categories = Category::all();

        return responseJson('1','success',$categories);

    }

    ////////////////////////////////////////////

    public function settings( )
    {
        //return responseJson(1, 'loaded', settings());

        $settings = Settings::find(1);

        return responseJson('1','success',$settings);
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
       
        $restaurants = Restaurant::with('categories')->where(function($query) use($request){

            if ($request->input('city_id'))
            {
                $query->whereHas('district',function($query) use ($request){
                    $query->where('districts.city_id',$request->city_id);
                });
            }
            // cat & (title || content)
            if ($request->input('keyword'))
            {
                $query->where(function($query) use($request){
                    $query->where('name','like','%'.$request->keyword.'%')
                    ->orWhere('phone','like','%'.$request->keyword.'%');
                });
            }

        })->paginate(20);
        return responseJson(1, 'success', $restaurants);
    }

    ///////////////////////////////////////////////////

    public function restaurant(Request $request)
    {
        $restaurant = Restaurant::with('categories')->find($request->restaurant_id);

        if (!$restaurant) {
            return responseJson(0, '404 no restaurant found');
        }

        return responseJson(1, 'success', $restaurant);
    }


    ///////////////////////////////////////////////////

    public function meals(Request $request)
    {
        $meals = Meal::where('restaurant_id',$request->restaurant_id)->paginate(10);

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
        $comments = Comment::with('client')->where('restaurant_id',$request->restaurant_id)->paginate(10);

        return responseJson('1','success',$comments);

    }

    ///////////////////////////////////////////////////
    
    // public function payments(Request $request)// for one restaurant //
    // {
    //     $payments = Payment::where('restaurant_id',$request->restaurant_id)->get();

    //     return responseJson('1','success',$payments);
    // }

    

    ///////////////////////////////////////////////////
    

    public function offers( )
    {
        $now = Carbon::now();

        $offers = Offer::where('start_date', '<=', $now)
        ->where('end_date', '>=', $now)
        ->latest()->paginate(20);

        return responseJson('1','success',$offers);
    }

    ///////////////////////////////////////////////////

    public function offer( Request $request)
    {
        $offer = Offer::find($request->offer_id);

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
        
    
            $contact = Contact::create($request->all()); 
    
          Mail::to('laravelemail2019@gmail.com')
                   ->send(new ContactUs( $contact));
    
                   return responseJson('1','Thanks for contacting us!');
    
    }

    ////////////////////////////////////////////////

  
    
}



