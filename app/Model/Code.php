<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Code extends Model
{
    protected $table = 'code';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function getItems(){
    	return Code::all();
    }
    public static function getItemByID($id){
        return Code::findOrFail($id);
    }
    public static function getItemByname($macode){
    	return Code::where('macode',$macode)->first();
    }
    public function addItem($arItem){
    	return Code::insert($arItem);
    }
    public function deleteItem($id){
    	return DB::delete('delete from code where id = ?',[$id]);
    }
    

}
