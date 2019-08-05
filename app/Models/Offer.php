<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('content', 'restaurant_id', 'title', 'start_date', 'end_date', 'image');

    // public function getImageFullPathAttribute()
    // {
    //     return asset($this->image);
    // }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}