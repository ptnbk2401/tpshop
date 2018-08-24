<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product;
class Cart extends Model
{
    protected $table = 'shopcart';
    protected $primaryKey = ['id_user', 'id_product'];
    public $timestamps = false;
    public $incrementing = false;

    public static function getItems($id_user){
        return Cart::where('id_user',$id_user)->get();
    }
    public static function getItem($arItem){
        return Cart::where('id_user',$arItem['id_user'])->where('id_product',$arItem['id_product'])->first();
    }
    public static function addCart($arItem){
        return Cart::insert($arItem);
    }
    public static function editCart($arItem){
        return DB::update('update shopcart set soluong = ? where id_user = ? && id_product = ?',[$arItem['soluong'],$arItem['id_user'],$arItem['id_product']]);
    }
     public static function delCart($id_user,$id_product){
        if($id_product == 0) {
            return DB::delete('delete from shopcart where id_user = ? ', [$id_user]);
        } else {
            return DB::delete('delete from shopcart where id_user = ? && id_product = ?', [$id_user,$id_product]);
        }
        
    }


}
