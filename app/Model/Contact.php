<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function getRememberToken(){
        return null;
    }
    public function setRememberToken($token){
        $token = null;
    }
    public function getItems(){
    	return Contact::orderBy('reply','ASC')->orderBy('id','DESC')->paginate(10);
    }
    public static function getItemByID($id){
    	return Contact::findOrFail($id);
    }

    public function addItem($arItem){
    	return Contact::insert($arItem);
    }

    public function reply($id){
        return DB::update('update contact set reply = 1 where id = ?',[$id]);
    }
    public function deleteItem($id){
    	return DB::delete('delete from contact where id = ?',[$id]);
    }
}
