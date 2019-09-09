<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('content_ar','content_en', 'restaurant_id', 'title_ar','title_en', 'start_date', 'end_date', 'image');

   

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}