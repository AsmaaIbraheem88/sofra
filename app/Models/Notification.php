<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title_ar', 'content_ar','title_en', 'content_en', 'action', 'notificationable_id', 'notificationable_type', 'order_id');

    public function notificationable()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

}