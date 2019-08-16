<?php

namespace App\Http\Controllers\Api\Restaurant;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;

use Mail;
use App\Mail\ResetPassword;
use App\Models\Token;


use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


   public function rejectOrder(Request $request )

   {

       $validator = validator()->make($request->all(),[

           'order_id' => 'required|exists:orders,id',
       ]);
   
       if($validator->fails())
       {
       $data = $validator->errors();
       return responseJson('0',$validator->errors()->first(),$data);

       }
   

       $order = Order::find($request->order_id);
     

       if($order->status == 'pending')
       {
         $order->Update([
           'status' => 'rejected',
           ]);

          
   
           $client = $order->client;

           
            /* notification */
          $client->notifications()->create([
   
           'title' => ' تم رفض الطلب من المطعم ',
           'content' => ' تم رفض الطلب من المطعم ',
           'order_id' => $order->id,
   
           ]);
   
           
           $tokens =$client->tokens()->where('token','!=','')->pluck('token')->toArray();
           
         
           $title = ' تم رفض الطلب من المطعم ';
           $body = ' تم رفض الطلب من المطعم ';
           $data =[
   
               'user_type' => 'client',
               'action' => 'rejected-order',
               'order_id' => $order->id
   
           ];
       
           $send = notifyByFirebase($title,$body,$tokens,$data);
   
           /* notification */
   
           return responseJson('1','loaded', $order);
   
        
       
       }else
       {
         return responseJson('0','لا يمكنك رفض هذا الطلب');
       }

      
  }


  /////////////////////////////////////////////////////////////////

  public function acceptOrder(Request $request )

   {

       $validator = validator()->make($request->all(),[

           'order_id' => 'required|exists:orders,id',
       ]);
   
       if($validator->fails())
       {
       $data = $validator->errors();
       return responseJson('0',$validator->errors()->first(),$data);

       }

       $order = Order::find($request->order_id);

       if($order->status == 'pending')
       {
         
         $order->Update([
         'status' => 'accepted',
         ]);
 
         $client = $order->client;
        /* notification */
        $client->notifications()->create([

        'title' => ' تم قبول الطلب من المطعم ',
        'content' => ' تم قبول الطلب من المطعم ',
        'order_id' => $order->id,

        ]);

        
        $tokens =$client->tokens()->where('token','!=','')->pluck('token')->toArray();
        
        
        $title = ' تم قبول الطلب من المطعم ';
        $body = ' تم قبول الطلب من المطعم ';
        $data =[

            'user_type' => 'client',
            'action' => 'accepted-order',
            'order_id' => $order->id

        ];
    
        $send = notifyByFirebase($title,$body,$tokens,$data);

        /* notification */

        return responseJson('1','loaded', $order);

    
 
       }else
       {
         return responseJson('0','هذا الطلب لم يتم  طلبه');
       }
   

      
    
   
  }


  /////////////////////////////////////////////////////////////////

 
 public function order(Request $request)
 {
     $order = Order::find($request->order_id);

     if (!$order) {
       return responseJson(0, '404 no order found');
   }

   if ($request->user()->notifications()->where('order_id',$order->id)->first())
   {
        $request->user()->notifications()->where('order_id',$order->id)->update([
            'is_read' => 1
        ]);
    
   }

     return responseJson('1','success',$order);
 }

 ///////////////////////////////////////////////////
    
  public function orders(Request $request)
  {
      // 'pending في انتظار', 'accepted مقبلول', 'rejected مرفوض', 'delivered مستلم ', 'declined راجع'
      $orders = $request->user()->whereHas('orders',function($query) use ($request){

          if($request->input('state') == 'new')
          {
              $query->where('orders.status','pending');
             
          }

          if($request->input('state') == 'current')
          {

              $query->where('orders.status','accepted');
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

  

}
