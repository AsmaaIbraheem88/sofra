<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model 
{

    protected $table = 'meals';
    public $timestamps = true;
    protected $fillable = array('name_ar','name_en', 'image', 'price', 'discount_price', 'processing_time', 'description_ar','description_en', 'restaurant_id');


    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('notes','quantity','price');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function scopeEnabled($q)
    {
        return $q->where('disabled','enable');
	}

   // protected $hidden = ['disabled'];

}