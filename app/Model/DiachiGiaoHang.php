<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DiachiGiaoHang extends Model
{
    protected $table = 'diachigiaohang';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function checkUser($id_user){
    	return DiachiGiaoHang::where('id_user',$id_user)->count();
    }
    public static function addItem($arItem){
    	return DiachiGiaoHang::insert($arItem);
    }
    public static function getItem($id_user){
    	return DiachiGiaoHang::where('id_user',$id_user)->first();
    }

    public static function editItem($arItem,$id){
        if( DB::update('update diachigiaohang set fullname=?,phone=?,address=?,tinh=?,quan=?,phuong=?  where id_user = ?',[$arItem['fullname'],$arItem['phone'],$arItem['address'],$arItem['tinh'],$arItem['quan'],$arItem['phuong'],$id])) {
            return 1;
        } return 0;
    }
}
