<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class Thanhtoan extends Model
{
   
    public static function getPayMethod(){
        return DB::select('select * from pay_method');
    }
    public static function getVanchuyen(){
        return DB::select('select * from hinhthucvanchuyen');
    }
   


}
