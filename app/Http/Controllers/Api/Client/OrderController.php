<?php

namespace App\Http\Controllers\Api\Client;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Meal;
use App\Models\Token;


use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function newOrder(Request $request )

     {
      //  dd(env('FIREBASE_API_ACCESS_KEY'));

        // 'restaurant_id', 'status', 'price', 'delivery_cost', 'total_price', 'commission', 'client_id', 'notes'

      $validator = validator()->make($request->all(),[

        'restaurant_id' => 'required|exists:restaurants,id',
        'meals.*.meal_id' => 'required|exists:meals,id',
        'meals.*.quantity' => 'required',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'address' => 'required',

      ]);

       if($validator->fails())
      {
        $data = $validator->errors();
        return responseJson('0',$validator->errors()->first(),$data);

      }


      $restaurant = Restaurant::find($request->restaurant_id);

      
      //restaurant closed or open (first validation)
      if($restaurant->status == 'close')
      {
        return responseJson('0','  عذرا المطعم غير متاح الوقت الحالي');
      }



      //client
      $order = $request->user()->orders()->create([

        'restaurant_id' => $request->restaurant_id,
        'notes' => $request->notes,
        'status' => 'pending',
        'address' => $request->address,
        'payment_method_id' => $request->payment_method_id,
      ]);


      $cost = 0;
      $delivery_cost = $restaurant->delivery_cost;
      

      //meals
      foreach($request->meals as $i)
      {
        //['meal_id'=>1,  'quantity'=>1,  'special_order'=>'no tomato']
        $meal = Meal::find($i['meal_id']);
        $readyMeal = [

            $i['meal_id'] =>[

                'special_order'=> (isset($i['special_order'])) ? $i['special_order'] : '',
                'quantity' => $i['quantity'],
                'price' => $meal->price
            ]

        ];

        $order->meals()->attach($readyMeal);
       
        $cost += ($meal->price * $i['quantity']);

      }

      //minimum_charge  (second validation)

      if( $cost >= $restaurant->minimum_charge)
      {

        $total = $cost + $delivery_cost ;

        $commission = settings()->commission * $cost ;

        // $net =  $total - $commission ; //صافي ربح المطعم 

        $update = $order->update([

            'price' => $cost,
            'delivery_cost' => $delivery_cost, 
            'total_price' =>$total, 
            'commission' =>$commission

        ]);


        /* notification */
        
        $restaurant->notifications()->create([

            'title_ar' => 'لديك طلب جديد',
            'title_en' => 'You Have New Order ',
            'content_ar' => '  لديك طلب جديد من العميل '.$request->user()->name,
            'content_en' => 'You Have New Order By Client'.$request->user()->name,
            'order_id' => $order->id,

        ]);

        $tokens =$restaurant->tokens()->where('token','!=','')->pluck('token')->toArray();

        


        $title =  ' لديك طلب جديد من العميل ';
        $body =  ' لديك طلب جديد من العميل ';
        $data =[

            'user_type' => 'restaurant',
            'action' => 'new-order',
            'order_id' => $order->id

        ];

        
       
        $send = notifyByFirebase($title,$body,$tokens,$data);
      
        // dd($send);
        

         /* notification */

         $orderData =[
            'order' => $order->fresh()->load('meals'),
         ];

         return responseJson('1',' تم الطلب بنجاح', $orderData);

      }else{
        $order->items()->delete();
        $order->delete();
        return responseJson('0','هذا الطلب يجب ان لا يكون اقل من'.$restaurant->minimum_charge.'ريال');
      }

     
    }


    /////////////////////////////////////////////////////////////////

    public function declineOrder(Request $request )

    {
        $order = $request->user()->orders()->findOrFail($request->order_id);

        if($order->status == 'delivered' || $order->status == 'accepted')
        {
          $order->Update([
            'status' => 'declined',
            ]);
    
            $restaurant = $order->restaurant;
       
             /* notification */
        
    
            $restaurant->notifications()->create([
              'title_ar'      => 'تم رفض توصيل طلبك من العميل',
              'title_en'   => 'Your order delivery is declined by client',
              'content_ar'    => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
              'content_en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
              'order_id'   => $request->order_id,
          ]);
    
           
            
            $tokens =$restaurant->tokens()->where('token','!=','')->pluck('token')->toArray();
            
          
            $title = ' تم رفض الطلب من العميل ';
            $body = ' تم رفض الطلب من العميل ';
            $data =[
    
                'user_type' => 'restaurant',
                'action' => 'declined-order',
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

      $order = $request->user()->orders()->findOrFail($request->order_id);

        if($order->status == 'accepted')
        {
          
          $order->Update([
          'status' => 'delivered',
          ]);
  
          $restaurant = $order->restaurant;
     
           /* notification */
          $restaurant->notifications()->create([
  
            'title_ar'      => 'تم تأكيد توصيل طلبك من العميل',
            'title_en'   => 'Your order is delivered to client',
            'content_ar'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
            'order_id'   => $request->order_id,
  
          ]);
  
          
          $tokens =$restaurant->tokens()->where('token','!=','')->pluck('token')->toArray();
          
        
          $title = ' تم استلام الطلب من العميل ';
          $body = ' تم استلام الطلب من العميل ';
          $data =[
  
              'user_type' => 'restaurant',
              'action' => 'declined-order',
              'order_id' => $order->id
  
          ];
      
          $send = notifyByFirebase($title,$body,$tokens,$data);
  
          /* notification */
  
          
  
          return responseJson('1','loaded', $order);
  
        }else
        {
          return responseJson('0','هذا الطلب لم يتم الموافقه عليه');
        }
    

       
     
    
   }


   /////////////////////////////////////////////////////////////////

  public function orders(Request $request)
  {
     // 'pending في انتظار', 'accepted مقبلول', 'rejected مرفوض', 'delivered مستلم ', 'declined راجع'

      $orders = $request->user()->orders()->where(function($query) use($request){

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

      })->with('restaurant','meals','client')->paginate(20);
     
      return responseJson(1, 'success',  $orders);


  }

  ///////////////////////////////////////////////////

  public function order(Request $request)
  {
      $order = Order::with('restaurant','meals','client')->find($request->order_id);

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


}
