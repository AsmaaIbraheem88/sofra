<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'district_id','address' ,'profile_image','password', 'pin_code', 'is_active');

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

}