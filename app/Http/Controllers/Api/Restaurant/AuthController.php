<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use App\Models\Restaurant;
use Mail;
use App\Mail\ResetRestaurant;
use App\Models\Token;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
     public function register(Request $request )

     { 
      // 'name', 'email', 'phone', 'district_id', 'minimum_charge', 'delivery_cost', 'whatsapp_link', 'image', 'status'

      //return $request->all();

      $validator = validator()->make($request->all(),[

        'name' => 'required',
        'district_id' => 'required|exists:districts,id',
        'phone' => 'required|unique:restaurants|digits:11',
        'password' => 'required|confirmed',
        'email' => 'required|unique:restaurants,email',
        'minimum_charge' => 'required|numeric',
        'delivery_cost' => 'required|numeric',
        'whatsapp' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'categories_list'      => 'required|array',
        'categories_list.*'    => 'required'    // validation on records  in array
      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }

      
        $restaurant = new Restaurant;
        $restaurant->name= $request->input('name');
        $restaurant->district_id= $request->input('district_id');
        $restaurant->phone= $request->input('phone');
        $restaurant->password = bcrypt($request->password);
        $restaurant->email= $request->input('email');
        $restaurant->minimum_charge= $request->input('minimum_charge');
        $restaurant->delivery_cost= $request->input('delivery_cost');
        $restaurant->whatsapp= $request->input('whatsapp');

        $restaurant->api_token = str_random('60');

        

        if($request->hasFile('image')){

          

          $fileNameWithExt = $request->file('image')->getClientOriginalName();
          // get file name
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          // get extension
          $extension = $request->file('image')->getClientOriginalExtension();

          $fileNameToStore = $filename.'_'.time().'.'.$extension;
          // upload
          $path = $request->file('image')->storeAs('public/restaurants', $fileNameToStore);

          $restaurant->image = $fileNameToStore;

        };

        $restaurant->save();

        if ($request->has('categories_list')) {

          $restaurant->categories()->attach($request->categories_list);
      }
        

      return responseJson('1','تم التسجيل بنجاح',[

       'api_token'=>$restaurant->api_token,
       'restaurant'=>$restaurant

      ]);

    }


    /////////////////////////////////////////////////////////////////

    public function login(Request $request )

    {

      // return $request->all();

      $validator = validator()->make($request->all(),[

       'email'=>'required',
       'password'=>'required', 
       

      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }

      $restaurant = restaurant::where('email',$request->email)->first();
      if($restaurant)
      {
       
       if(Hash::check($request->password,$restaurant->password))
       {

        //Check if restaurant active or no 
        
        if( $restaurant->is_active == 'inactive')
        {
          return responseJson('0','تم حظر حسابك ');
        }
        
        return responseJson('1','تم الدخول بنجاح',[

         'api_token' =>$restaurant->api_token,
         'restaurant' =>$restaurant

        ]);
       }else
       {
          return responseJson('0','البيانات غير صحيحه');
       }
      }else
      {
        return responseJson('0','البيانات غير صحيحه');
      }

    }


    /////////////////////////////////////////////////////////////////

     public function resetPassword(Request $request )
     {
          $user = restaurant::where('phone',$request->phone)->first();

         if($user)
         {

          $code =rand('1111','9999');

          $update = $user->update(['pin_code' => $code]);

          if($update)
          {
               Mail::to($user->email)
               ->send(new ResetRestaurant($user));

               return responseJson('1','من فضلك تصفح ايميلك', $user->pin_code);

          }

         }
     }

    
    /////////////////////////////////////////////////////////////////

     public function changePassword(Request $request )
     {


          $validator = validator()->make($request->all(),[

               'pin_code'=>'required',
               'phone'=>'required',
               'password'=>'required|confirmed', 
               

          ]);

          if($validator->fails())
          {
              $data = $validator->errors();
               return responseJson('0',$validator->errors()->first(),$data);

          }

         

           $user = restaurant::where('phone',$request->phone)
                          ->where('pin_code',$request->pin_code)
                         ->where('pin_code','!=',0)->first();

          
          if($user)

          {
               $user->password = bcrypt($request->password);
               
               $user->pin_code = null;

               $user->save();
               
               if($user->save())
               {
                     return responseJson('1','تم تغيير كلمه المرور بنجاح');
               }else
               {
                     return responseJson('0','حدث خطأ');
               }

          }else
          {
               return responseJson('0','البيانات غير صحيحه');
          }


     }


     /////////////////////////////////////////////////////////////////

      public function profile(Request $request )
      {
        

        $validator = validator()->make($request->all(),[
          'name' =>'required',
          'email'=>[Rule::unique('restaurants')->ignore($request->user()->id),'required']  ,
          'phone'=>[Rule::unique('restaurants')->ignore($request->user()->id),'required']  ,
          'district_id' => 'required|exists:districts,id',
          'password'=>'confirmed', 
          'minimum_charge' => 'required',
          'delivery_cost' => 'required',
          'whatsapp_link' => 'required',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'categories_list'      => 'array|required',
        

        ]);

     
      if($validator->fails())
      {
          $data = $validator->errors();
          return responseJson('0',$validator->errors()->first(),$data);

      }


      $loginUser = $request->user(); // object restaurant Model
       
      $loginUser->update($request->except(['password','image']));
      
      

      $request->user()->categories()->sync($request->categories_list);




      if ($request->has('password'))
      {
          $loginUser->password = bcrypt($request->password);
      }

      if($request->hasFile('image')){

        Storage::delete('public/restaurants/'.$loginUser->image);

        $fileNameWithExt = $request->file('image')->getClientOriginalName();
        // get file name
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // upload
        $path = $request->file('image')->storeAs('public/restaurants', $fileNameToStore);

        $loginUser->image = $fileNameToStore;

      };

      $loginUser->save();

      return responseJson(1,'تم تحديث البيانات',$loginUser);


    }

/////////////////////////////////////////////////////////////////////////

  public function notifications(Request $request)
  {

    $notifications = $request->user()->notifications()->latest()->paginate(10);
    return responseJson(1,'success ',$notifications);

  }
    

////////////////////////////////////////////////////////////////

public function notificationsCount(Request $request)
{

  $count = $request->user()->notifications()->where(function($query) use ($request){

    $query->where('is_read','0');

  })->count();

  return responseJson('1','loaded....',[

   'notifications-count' => $count,

  ]);

}
  

////////////////////////////////////////////////////////////////

  public function registerToken(Request $request )
  {

    $validator = validator()->make($request->all(),[

      'token'=>'required',  
      'type'=>'required|in:android,ios', 

    ]);

     if($validator->fails())
      {
          $data = $validator->errors();
          return responseJson('0',$validator->errors()->first(),$data);

      }

     

      Token::where('token',$request->token)->delete();

      // Token::create([

      //   'token' => '',
      //   'type' => '',
      //   'restaurant_id' =>  $request->user()->id

      // ]);

      $request->user()->tokens()->create($request->all());


       return responseJson('1','Token created successfully  ');


  } 
  ///////////////////////////////////////////////////////////////////// 

  public function removeToken(Request $request )
  {

    $validator = validator()->make($request->all(),[

      'token'=>'required',  
      

    ]);

     if($validator->fails())
      {
          $data = $validator->errors();
          return responseJson('0',$validator->errors()->first(),$data);

      }

     

      Token::where('token',$request->token)->delete();



       return responseJson('1','deleted successfully');


  } 

  ///////////////////////////////////////////////////////////////

  public function commissions(Request $request )
  {

    $count = $request->user()->orders()->whereIn('status',['delivered', 'declined'])->count();

    $total = $request->user()->orders()->whereIn('status',['delivered', 'declined'])->sum('total_price');

    $commission = $request->user()->orders()->whereIn('status',['delivered', 'declined'])->sum('commission'); 
    
    $payments = $request->user()->payments()->sum('amount');



    return responseJson('1','',compact('count','total','commission','payments'));



  } 

  ///////////////////////////////////////////////////////////////

  public function changeStatus(Request $request )
  {
   
    $restaurant = $request->user();

    $state = $restaurant->status;

    if ($state == 'open')
    {

      $restaurant->update(['status' => 'close']);

    }elseif($state == 'close')
    {
     
      $restaurant->update(['status' => 'open']);

    }
    
 
   return responseJson(1,'تم تحديث حاله المطعم',$restaurant);


}

/////////////////////////////////////////////////////////////////////////


}
