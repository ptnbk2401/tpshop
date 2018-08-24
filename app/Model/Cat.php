<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product;
class Cat extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id_cat';
    public $timestamps = false;


    public static function checkName($name){
        return Cat::where('name_cat','LIKE',$name)->count();
    }

    public function getItems(){
        return Cat::where('trash','!=',1)->get();
    }
    public function getRandItems(){
    	return DB::select('select * from category where trash != 1 order by rand() limit 5');
    }

    public function getItemsWithoutId($id){
        return Cat::where('trash','!=',1)->where('id_cat','!=',$id)->get();
    }
    
    public function getItem($id){
        return Cat::findOrFail($id);
    }
    
    public static function CountProduct($id){
    	return DB::update('update category set count_post = (select count(id) from product where product.id_cat = ?) where category.id_cat = ?',[$id,$id] );
    }
	
    public function getParent(){
    	return Cat::where('id_parent',0)->where('trash','!=',1)->get();
    }
    public function getChildAll(){
        return Cat::where('id_parent','!=',0)->where('trash','!=',1)->get();
    }
    public static function getChild($id_cat){
    	return Cat::where('id_parent',$id_cat)->where('trash','!=',1)->get();
    }
    public function addCat($arCat){
    	return Cat::insert($arCat);
    }
    public  function editCat($id,$arCat){
    	return Cat::where('id_cat',$id)->update($arCat);
    }
    public  function moveTrash($id){
        // UPDATE category SET trash = 0 WHERE id_cat = 14 OR id_cat IN (SELECT id_cat FROM (SELECT * FROM category) as cat WHERE id_parent = 14 )

    	$a = DB::update('update category set trash = 1 where id_cat = ? OR id_cat IN (SELECT id_cat FROM (SELECT * FROM category) as cat WHERE id_parent = ?)', [$id,$id]);
    	return $a;
    }

    public  function getTrash(){
    	return Cat::where('trash',1)->get();
    }
    public  function recycleTrash($id){
        
    	// Khôi phục từng danh mục
    	//$a = DB::update('update category set trash = 0 where id_cat = ?', [$id]);

    	// Khôi phục cha thì khôi phục luôn con

    	$objCat = Cat::findOrFail($id);
        if($objCat->id_parent != 0 ){
        	//Danh mục con
        	$a = DB::update('update category set trash = 0 where id_cat = ?', [$id]);
        } else {
        	//Danh mục cha
        	$a = DB::update('update category set trash = 0 where id_cat = ? OR id_cat IN (SELECT id_cat FROM (SELECT * FROM category) as cat WHERE id_parent = ?)', [$id,$id]);
        }
    	return $a;
    }

    public  function deleteTrash($id){
        
    	$objCat = Cat::findOrFail($id);
        if($objCat->id_parent != 0 ){
        	//Danh mục con
        	$a = DB::delete('delete from category where id_cat = ?', [$id]);
        } else {
        	//Danh mục cha
        	$a = DB::delete('delete from category where id_cat = ? OR id_cat IN (SELECT id_cat FROM (SELECT * FROM category) as cat WHERE id_parent = ?)', [$id,$id]);
        }
    	return $a;
    }
    public function allTrash($luachon){
    	if($luachon == 'delete'){
    		$a = DB::delete('delete from category where trash = 1');
    	}
    	else if($luachon == 'recycle'){
    		$a = DB::update('update category set trash = 0 where trash = 1');
    	}
    	return $a;
    }


}
