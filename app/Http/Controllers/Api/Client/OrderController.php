<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Governorate;
use Mail;
use App\Mail\ResetPassword;
use App\Models\Token;


use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function orders(Request $request)
  {
      // 'pending في انتظار', 'accepted مقبلول', 'rejected مرفوض', 'delivered مستلم ', 'declined راجع'

      $orders = $request->user()->whereHas('orders',function($query) use ($request){

          if($request->input('state') == 'current')
          {
              $query->where('orders.status','pending')
              ->orWhere('orders.status','acctepted');
          }

          if($request->input('state') == 'previous')
          {
              $query->where('orders.status','rejected')
              ->orWhere('orders.status','delivered')
              ->orWhere('orders.status','declined');
          }

      })->paginate(20);
      return responseJson(1, 'success',  $orders);


  }

  ///////////////////////////////////////////////////

  public function order(Request $request)
  {
      $order = Order::find($request->order_id);

      return responseJson('1','success',$order);
  }

  ///////////////////////////////////////////////////


}
