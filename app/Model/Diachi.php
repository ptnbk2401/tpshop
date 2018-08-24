<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Diachi extends Model
{
    public static function getTinh(){
    	return DB::select('select * from tinh_tp');
    }
    public static function getQuan(){
    	return DB::select('select * from quan_huyen');
    }
    public static function getPhuong(){
    	return DB::select('select * from phuong_xa');
    }
    
    public static function getInfo($tinh,$quan,$phuong){
    	return DB::select('select *,tinh_tp.name as tname,quan_huyen.name as qname,phuong_xa.name as pname, tinh_tp.type as ttype,quan_huyen.type as qtype,phuong_xa.type as ptype from tinh_tp inner join quan_huyen on tinh_tp.provinceid = quan_huyen.provinceid inner join phuong_xa on phuong_xa.districtid = quan_huyen.districtid where tinh_tp.provinceid = ? and quan_huyen.districtid = ? and phuong_xa.wardid = ? ',[$tinh,$quan,$phuong]);
    }

}
