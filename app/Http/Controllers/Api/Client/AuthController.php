<?php

namespace App\Http\Controllers\Api\Client;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Mail;
use App\Mail\ResetPassword;
use App\Models\Token;


use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function register(Request $request )

     {

      //return $request->all();

      $validator = validator()->make($request->all(),[

        'name' => 'required',
        'district_id' => 'required|exists:districts,id',
        'phone' => 'required|unique:clients|digits:11',
        'password' => 'required|confirmed',
        'email' => 'required|unique:clients',

      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }

      $request->merge(['password'=>bcrypt($request->password)]);
      $client = Client::create($request->all());
      $client->api_token = str_random('60');
      $client->save();
      return responseJson('1','تم التسجيل بنجاح',[

       'api_token'=>$client->api_token,
       'client'=>$client

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

      $client = Client::where('email',$request->email)->first();
      if($client)
      {
       
       if(Hash::check($request->password,$client->password))
       {

        //Check if client active or no 
        
        if( $client->is_active == 0)
        {
          return responseJson('0','تم حظر حسابك ');
        }
        
        return responseJson('1','تم الدخول بنجاح',[

         'api_token' =>$client->api_token,
         'client' =>$client

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
          $user = Client::where('phone',$request->phone)->first();

         if($user)
         {

          $code =rand('1111','9999');

          $update = $user->update(['pin_code' => $code]);

          if($update)
          {
               Mail::to($user->email)
               ->send(new ResetPassword($user));

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

         

           $user = Client::where('phone',$request->phone)
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
          'email'=>[Rule::unique('clients')->ignore($request->user()->id),'required']  ,
          'phone'=>[Rule::unique('clients')->ignore($request->user()->id),'required']  ,
          'district_id' => 'required|exists:districts,id',
          'password'=>'confirmed', 
        

        ]);

     
      if($validator->fails())
      {
          $data = $validator->errors();
          return responseJson('0',$validator->errors()->first(),$data);

      }


      $loginUser = $request->user(); // object Client Model
       
      $loginUser->update($request->except(['password']));


      if ($request->has('password'))
      {
          $loginUser->password = bcrypt($request->password);
      }

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
      //   'client_id' =>  $request->user()->id

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



}
