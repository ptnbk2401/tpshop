<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getItems(){
        return Order::all();
    }
    public static function getItem($id){
        return Order::where('id',$id)->get();
    }
    public static function addOrder($arOrder){
        return Order::insert($arOrder);
    }
    public static function getOrder($id_user){
        return Order::where('id_user',$id_user)->get();
    }
    public static function delOrder($id){
        return DB::delete('delete from orders where id = ? ', [$id]);
        
    }
    public static function changeTTDH($idOrder,$val){
        return DB::update('update orders set trangthaidonhang = ? where id = ? ', [$val,$idOrder]);
        
    }


}
