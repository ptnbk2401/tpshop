<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Capsule\Manager;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function getRememberToken(){
        return null;
    }
    public function setRememberToken($token){
        $token = null;
    }
    public function getItems(){
    	return User::all();
    }
    public static function getItemByID($id){
    	return User::findOrFail($id);
    }

    public function addItem($arItem){
    	return User::insert($arItem);
    }
    public function deleteItem($id){
    	return DB::delete('delete from users where id = ?',[$id]);
    }
    public static function editItem($arItem,$id){
        if( DB::update('update users set password=?,fullname=?,role=?  where id = ?',[$arItem['password'],$arItem['fullname'],$arItem['role'],$id])) {
            return 1;
        } return 0;
    }
    
    public static function editUserInfo($arItem,$id){
        if( DB::update('update users set fullname=?,email=?  where id = ?',[ $arItem['fullname'],$arItem['email'],$id])) {
            return 1;
        } return 0;
    }
	public static function editUserPass($pass,$id){
	    if( DB::update('update users set password=? where id = ?',[ $pass,$id])) {
	    	return 1;
	    } return 0;
    }

}
