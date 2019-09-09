<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model 
{

    protected $table = 'districts';
    public $timestamps = true;
    protected $fillable = array('name_ar','name_en', 'city_id');

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

}