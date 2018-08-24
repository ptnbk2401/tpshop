<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Cat;

function findIDChild( $id_parent){
    $ID = array();
    $objID = DB::select('select id_cat from category where id_parent = ?',[$id_parent]);
    if(count($objID) > 0){
        foreach ($objID as $item) {
            $ID[] = $item->id_cat;
            $arIDCon = findIDChild($item->id_cat);
            if(count($arIDCon) > 0){
                foreach ($arIDCon as $citem) {
                    $ID[] = $citem;
                }
                // $ID+=$arIDCon;
            }
        }
    }
    return $ID;
}



class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function checkName($name){
        return Product::where('name','LIKE',$name)->count();
    }
    public function getItems(){
        return DB::table('product')
        ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
        ->leftjoin('gift','gift.id_gift','=','product.id_gift')
        ->where('product.trash','!=',1)
        ->get();
    }
    public function getProductByCat($id_cat){
    	if(count(findIDChild($id_cat)) > 0 ){
            $arID = findIDChild($id_cat) ;
            $arID[] = $id_cat;
            // dd($arID);
            return DB::table('product')
            ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
            ->leftjoin('gift','gift.id_gift','=','product.id_gift')
            ->where('product.trash','!=',1)
            ->whereIN('product.id_cat',$arID)
            ->paginate(6);
        } else {
            return DB::table('product')
            ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
            ->leftjoin('gift','gift.id_gift','=','product.id_gift')
            ->where('product.trash','!=',1)
            ->where('product.id_cat',$id_cat)
            ->paginate(6);
        }
    }

    public function getHotItems(){
        return DB::table('product')
        ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
        ->leftjoin('gift','gift.id_gift','=','product.id_gift')
        ->where('product.trash','!=',1)
        ->where('product.hot',1)->orderBy('product.id','DESC')->limit(8)
        ->get();
    }
    public function getNewItems(){
        return DB::table('product')
        ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
        ->leftjoin('gift','gift.id_gift','=','product.id_gift')
        ->where('product.trash','!=',1)
        ->orderBy('product.id','DESC')->limit(8)
        ->get();
    }
    public function getItem($id){
    	return DB::table('product')
        ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
        ->leftjoin('gift','gift.id_gift','=','product.id_gift')
        ->where('product.trash','!=',1)
        ->where('product.id',$id)
        ->first();
    }
    public function getItemByCat($id_cat){
    	return Product::where('id_cat',$id_cat);
    }
    
    public function addProduct($arProduct){
    	$id_cat = $arProduct['id_cat'];
    	if( $a = Product::insert($arProduct)){
    		Cat::CountProduct($id_cat);
    		return $a;
    	}

    }
    public  function editProduct($id,$arProduct){
        return Product::where('id',$id)->update($arProduct);
    }
    public  function editHot($id,$stt){
        return DB::update('update product set hot = ? where id = ?',[$stt,$id]);
    }
    public  function editSale($id,$stt){
    	return DB::update('update product set sale = ? where id = ?',[$stt,$id]);
    }
    public  function moveTrash($id){

    	$a = DB::update('update product set trash = 1 where id = ? ', [$id]);
    	return $a;
    }
    public  function getTrash(){
    	return Product::where('trash',1)->get();
    }
    public  function recycleTrash($id){

    	$a = DB::update('update product set trash = 0 where id = ?', [$id]);
    	
    	return $a;
    }

    public  function deleteTrash($id){
    	$objProduct = Product::findOrFail($id);
    	$id_cat = $objProduct->id_cat;

    	if( $a = DB::delete('delete from product where id = ?', [$id]) ){
    		Cat::CountProduct($id_cat);
    	}
    	return $a;
    }
    public function allTrash($luachon){
    	if($luachon == 'delete'){

    		$a = DB::delete('delete from product where trash = 1');
    		
    	}
    	else if($luachon == 'recycle'){
    		$a = DB::update('update product set trash = 0 where trash = 1');
    	}
    	return $a;
    }

    public function searchItems($content){
            return DB::table('product')
            ->leftjoin('category as cat','cat.id_cat','=','product.id_cat')
            ->leftjoin('gift','gift.id_gift','=','product.id_gift')
            ->where('product.trash','!=',1)
            ->where('name','LIKE','%'.$content.'%')
            ->orWhere('preview','LIKE','%'.$content.'%')
            ->orWhere('name_cat','LIKE','%'.$content.'%')
            ->get();
    }
}
