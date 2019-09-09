<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'district_id', 'minimum_charge', 'delivery_cost', 'whatsapp', 'image', 'status');



    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    public function getTotalCommissionsAttribute()
    {
        $commissions = $this->orders()->where('status','delivered')->sum('commission');
        return $commissions;
    }

    public function getTotalPaymentsAttribute()
    {
        $payments = $this->payments()->sum('amount');
        return $payments;
    }

    public function scopeActivated($query)
    {
        return $query->where('is_active','active');
    }


}