<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware' =>'auto-check-permission'],function(){    // un authenticated  admin
    Config::set('auth.defines','admin'); //to use admin model


    Route::get('login','AdminAuth@login');
    Route::post('login','AdminAuth@dologin');
    Route::get('forgot/password', 'AdminAuth@forgot_password');
    Route::post('forgot/password', 'AdminAuth@forgot_password_post');
    Route::get('reset/password/{token}', 'AdminAuth@reset_password');
    Route::post('reset/password/{token}', 'AdminAuth@reset_password_final');

    Route::group(['middleware' => 'admin:admin'],function(){   // authenticated admin (middleware admin&gaurd admin)
      
        Route::get('/', function () {
            return view('admin.home');
        });
        Route::any('logout','AdminAuth@logout');

        Route::resource('admin', 'AdminController');
        Route::delete('admin/destroy/all', 'AdminController@multi_delete');

        Route::resource('users', 'UserController');
        Route::delete('users/destroy/all', 'UserController@multi_delete');

        Route::resource('roles', 'RoleController');
        Route::delete('roles/destroy/all', 'RoleController@multi_delete');

        Route::get('settings', 'SettingsController@setting_view');
        Route::post('settings', 'SettingsController@setting_save');

        Route::resource('payments', 'PaymentsController');
        Route::delete('payments/destroy/all', 'PaymentsController@multi_delete');

        Route::resource('offers', 'OfferController');
        Route::delete('offers/destroy/all', 'OfferController@multi_delete');

        Route::resource('contacts', 'ContactController');
        Route::delete('contacts/destroy/all', 'ContactController@multi_delete');


        Route::resource('cities', 'CityController');
        Route::delete('cities/destroy/all', 'CityController@multi_delete');

        Route::resource('districts', 'DistrictController');
        Route::delete('districts/destroy/all', 'DistrictController@multi_delete');

        Route::resource('categories', 'CategoryController');
        Route::delete('categories/destroy/all', 'CategoryController@multi_delete');

        Route::resource('restaurants', 'RestaurantController');
        Route::get('restaurants/{id}/activated', 'RestaurantController@activated');
        Route::get('restaurants/{id}/show', 'RestaurantController@show');
        Route::delete('restaurants/destroy/all', 'RestaurantController@multi_delete');
       

        
        Route::resource('clients', 'ClientController');
        Route::get('clients/{id}/activated', 'ClientController@activated');
        Route::get('clients/{id}/show', 'ClientController@show');
        Route::delete('clients/destroy/all', 'ClientController@multi_delete');

        Route::resource('orders', 'OrderController');
        Route::get('orders/{id}/show', 'OrderController@show');

        Route::get('change-password','AdminAuth@changePassword');
        Route::post('change-password','AdminAuth@changePasswordSave');
       

       

        Route::get('lang/{lang}', function ($lang) {
            session()->has('lang')?session()->forget('lang'):'';//if session lang exist destroy 
            $lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
            return back();
        });

        /////////////////////////////////////////////

        // Route::get('lang/{lang}', function ($lang) {

        //     if(in_array($lang,['en','ar'])){

        //         if(auth()->user()){

        //             $user = auth()->user();
        //             $user->lang = $lang;
        //             $user->save();
        //         }else{
        //             if(session()->has('lang'))
        //             {
        //                 session()->forget('lang');
        //             }

        //             session()->put('lang', $lang);
        //         }

               
        //     }else{

        //          if(auth()->user()){

        //             $user = auth()->user();
        //             $user->lang = 'en';
        //             $user->save();
        //         }else{
        //             if(session()->has('lang'))
        //             {
        //                 session()->forget('lang');
        //             }
                    
        //             session()->put('lang', 'en');
        //         }
        //     }
            
        //     return back();
        // });

    ///////////////////////////////////////////////////////////


    });

   
    
});

