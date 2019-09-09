<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name_ar','name_en');

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }

}