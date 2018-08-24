<?php

namespace App\Http\Controllers\TPShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Cat;
use App\Model\Cart;
use Auth;
class IndexController extends Controller
{
	public function __construct(Product $objProduct, Cat $objCat ){
		$this->objProduct = $objProduct;
		$this->objCat = $objCat;
	}

    public function index(){
    	$objHotItems = $this->objProduct->getHotItems();
    	$objNewItems = $this->objProduct->getNewItems();
    	return view('tpshop.index.index',compact('objHotItems','objNewItems'));
    }
}
