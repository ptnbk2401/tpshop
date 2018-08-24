<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Size extends Model
{
    protected $table = 'size_product';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function getItems(){
        return Size::all();
    }
    public function getType(){
    	return Size::select('type')->groupBy('type')->get();
    }
    public static function getItemByID($id){
        return Size::findOrFail($id);
    }
    public static function getItemByType($type){
    	return Size::where('type',$type)->get();
    }
    public function addItem($arItem){
    	return Size::insert($arItem);
    }
    public function deleteItem($id){
    	return DB::delete('delete from size_product where id = ?',[$id]);
    }
    

}
