<?php

namespace App\Http\Controllers\TPShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Cat;

class CatController extends Controller
{
	public function __construct(Product $objProduct, Cat $objCat ){
		$this->objProduct = $objProduct;
		$this->objCat = $objCat;
	}
    public function index($slug,$id){
    	$name_cat = Cat::find($id)->name_cat;
    	$objProductItems = $this->objProduct->getProductByCat($id);
    	// dd($objProductItems);
    	return view('tpshop.cat.index',compact('objProductItems','name_cat'));
    }
}
