<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// general apis
Route::group(['prefix' => 'v1' , 'namespace' => 'Api'],function(){

    Route::get('cities','GeneralController@cities'); 
    Route::get('categories','GeneralController@categories');
    Route::get('districts','GeneralController@districts');
    Route::get('settings','GeneralController@settings');
    Route::get('payment-methods','GeneralController@paymentMethods');
    Route::get('restaurants','GeneralController@restaurants');
    Route::get('restaurant','GeneralController@restaurant');
    Route::get('meals','GeneralController@meals');
    Route::get('meal','GeneralController@meal');
    Route::get('restaurant/comments','GeneralController@comments');
    Route::get('offers','GeneralController@offers');
    Route::get('offer','GeneralController@offer');
    Route::post('contact','GeneralController@contact');
   

    

	 // client apis
    Route::group(['prefix' => 'client', 'namespace' => 'Client'],function(){     // un authenticated client apis
        
        Route::post('register','AuthController@register');
        Route::post('login','AuthController@login');
        Route::post('reset-password','AuthController@resetPassword');
        Route::post('change-password','AuthController@changePassword');
       

		
		
        Route::group(['middleware' => 'auth:client'],function(){   // authenticated client apis

            Route::post('profile','AuthController@profile');
            Route::post('register-token','AuthController@registerToken');
            Route::post('remove-token','AuthController@removeToken');
            Route::get('notifications','AuthController@notifications');
            Route::get('notifications-count','AuthController@notificationsCount');

            Route::get('orders','OrderController@orders');
            Route::get('order','OrderController@order');
            Route::post('new-order','OrderController@newOrder');
            Route::post('decline-order','OrderController@declineOrder');
            Route::post('accept-order','OrderController@acceptOrder');

            Route::post('new-comment','AuthController@newComment');


           
           

           
           
			
		});
    });
    




	
	// restaurant apis
	Route::group(['prefix' => 'restaurant','namespace' => 'Restaurant'],function(){      // un authenticated restaurant apis
		
		Route::post('register','AuthController@register');
        Route::post('login','AuthController@login');
        Route::post('reset-password','AuthController@resetPassword');
        Route::post('change-password','AuthController@changePassword');
		
        Route::group(['middleware' => 'auth:restaurant'],function(){    // authenticated restaurant apis	
            
            Route::post('profile','AuthController@profile');
            Route::post('register-token','AuthController@registerToken');
            Route::post('remove-token','AuthController@removeToken');
            Route::get('notifications','AuthController@notifications');
            Route::get('notifications-count','AuthController@notificationsCount');

            Route::post('new-meal','MealController@newMeal');
            Route::post('update-meal','MealController@updateMeal');
            Route::post('delete-meal','MealController@deleteMeal');

            Route::post('new-offer','OfferController@newOffer');
            Route::post('update-offer','OfferController@updateOffer');
            Route::post('delete-offer','OfferController@deleteOffer');



            Route::post('accept-order','OrderController@acceptOrder')->middleware('check-commissions');
            // Route::post('confirm-order','OrderController@confirmrOrder');
            Route::post('reject-order','OrderController@rejectOrder');
            Route::get('orders','OrderController@orders');
            Route::get('order','OrderController@order');


            Route::post('change-state','AuthController@changeStatus');

            Route::get('commissions','AuthController@commissions');
			
		});
	});
});


/////////////////////////////////////////////////////////////////////


