<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $table = 'gift';
    protected $primaryKey = 'id_gift';
    public $timestamps = false;

    public static function getItems(){
    	return Gift::where('id_gift','>',0)->get();
    }
}
