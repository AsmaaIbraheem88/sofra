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
    Route::get('payments','GeneralController@payments');
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

            Route::post('meals/create','MealController@create');
            Route::post('meals/update/{id}','MealController@update');
            Route::delete('meals/delete/{id}','MealController@delete');

            Route::post('offers/create','OfferController@create');
            Route::post('offers/update/{id}','OfferController@update');
            Route::delete('offers/delete/{id}','OfferController@delete');


            Route::get('orders','OrderController@orders');
            Route::get('order','OrderController@order');
			
		});
	});
});


/////////////////////////////////////////////////////////////////////



