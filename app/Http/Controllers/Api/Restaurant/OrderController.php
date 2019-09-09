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

    $order= $request->user()->orders()->findOrFail($request->order_id);
    
       if($order->status == 'pending')
       {
         $order->Update([
           'status' => 'rejected',
           ]);

          
   
           $client = $order->client;

           
            /* notification */
          $client->notifications()->create([
   
            'title_ar' => 'تم رفض طلبك',
            'title_en' => 'Your order is rejected',
            'content_ar' => 'تم رفض الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is rejected',
            'order_id' => $request->order_id,
   
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

    $order= $request->user()->orders()->findOrFail($request->order_id);

       if($order->status == 'pending')
       {
         
         $order->Update([
         'status' => 'accepted',
         ]);
 
        $client = $order->client;
        /* notification */
        $client->notifications()->create([

            'title_ae' => 'تم قبول طلبك',
            'title_en' => 'Your order is accepted',
            'content_ar' => 'تم قبول الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is accepted',
            'order_id' => $request->order_id,

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
  /////////////////////////////////////////////////////

  public function confirmOrder(Request $request)
  {
      $order = $request->user()->orders()->find($request->order_id);
      if (!$order)
      {
          return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
      }
      if ($order->state != 'accepted')
      {
          return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
      }
      $order->update(['state' => 'delivered']);

      $client = $order->client;
        /* notification */
        $client->notifications()->create([

            'title_ar' => 'تم تأكيد توصيل طلبك',
            'title_en' => 'Your order is delivered',
            'content_ar' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is delivered to you',
            'order_id' => $request->order_id,

        ]);

        
        $tokens =$client->tokens()->where('token','!=','')->pluck('token')->toArray();
        
        
        $title =  'تم تأكيد التوصيل للطلب  ';
        $body = 'تم تأكيد التوصيل للطلب رقم '.$request->order_id;
        $data =[

            'user_type' => 'client',
            'action' => 'accepted-order',
            'order_id' => $order->id

        ];
    
        $send = notifyByFirebase($title,$body,$tokens,$data);

        /* notification */
   
      return responseJson(1,'تم تأكيد الاستلام');
  }


  /////////////////////////////////////////////////////////////////

 
 public function order(Request $request)
 {
     $order = Order::with('restaurant','meals','client')->findOrFail($request->order_id);
 

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
      $orders = $request->user()->orders()->where(function($query) use ($request){

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

      })->with('restaurant','meals','client')->paginate(20);
      return responseJson(1, 'success',  $orders);
  }

  ///////////////////////////////////////////////////

  

}
