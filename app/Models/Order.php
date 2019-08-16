<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'status', 'price', 'delivery_cost', 'total_price', 'commission', 'client_id', 'notes','payment_method_id','address');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal')->withPivot('special_order','quantity','price');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function payment_method(){

        $this->belongsTo('App\Models\PaymentMethod');
    }

}