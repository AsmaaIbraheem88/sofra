<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('sitename_ar','sitename_en','logo','icon','email','main_lang','description','keywords','status','message_maintenance','max_credit','commission', 'commission_msg1', 'commission_msg2');




}