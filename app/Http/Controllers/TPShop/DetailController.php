<?php

namespace App\Http\Controllers\TPShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Cat;

class DetailController extends Controller
{
	public function __construct(Product $objProduct, Cat $objCat ){
		$this->objProduct = $objProduct;
		$this->objCat = $objCat;
	}
    public function index($slug,$id){
        $objHotItems = $this->objProduct->getHotItems();
    	$objProductItem = $this->objProduct->getItem($id);
    	//dd($id);
    	return view('tpshop.detail.index',compact('objProductItem','objHotItems'));
    }
}
